<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\ProductRepository;
use App\Repository\ReservedProductRepository;
use App\Repository\WarehouseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ProductRemoveReserveProcessor implements ProcessorInterface
{
    private \Doctrine\Persistence\ObjectManager $entityManager;
    public function __construct(private WarehouseRepository $warehouseRepository, private ProductRepository  $productRepository,
                                private ReservedProductRepository $reservedProductRepository, private ManagerRegistry $doctrine)
    {
        $this->entityManager = $this->doctrine->getManager();
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $resJSON = [];
        $productReceivedCodes = $data->getProductCodes();
        $warehouse = $this->warehouseRepository->findOneBy(["name" => $data->getName()]);

        if ($warehouse === null) {
            throw new BadRequestHttpException("Warehouse name doesn't exist");
        }

        foreach ($productReceivedCodes as $productReceivedCode) {
            if (gettype($productReceivedCode) !== "string") {
                $resJSON[] = ["productCode"=>$productReceivedCode,"status"=>"wrong variable type"];
                continue;
            }
            $reservedProduct = $this->reservedProductRepository->findOneBy(["productCode" => $productReceivedCode]);
            $product = $this->productRepository->findOneBy(["productCode" => $productReceivedCode]);
//           Проверка на существование
            if ($reservedProduct === null) {
                $resJSON[] = ["productCode"=>$productReceivedCode,"status"=>"error"];
                continue;
            }
            if ($product === null) {
                throw new ConflictHttpException("Tried to remove reserve from not existing entity");
            }
            $this->entityManager->remove($reservedProduct);
            $this->entityManager->flush();
            $product->setQuantity($product->getQuantity() + 1);
            $this->entityManager->flush();

            $resJSON[] = ["productCode"=>$productReceivedCode,"status"=>"success"];
        }

        return $resJSON;
    }
}
