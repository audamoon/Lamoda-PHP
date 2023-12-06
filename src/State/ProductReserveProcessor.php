<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\ProductRepository;
use App\Repository\ReservedProductRepository;
use App\Repository\WarehouseRepository;
use App\Entity\ReservedProduct;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductReserveProcessor implements ProcessorInterface
{
    private \Doctrine\Persistence\ObjectManager $entityManager;

    public function __construct(private ProcessorInterface $persistProcessor, private WarehouseRepository $warehouseRepository,
                                private ProductRepository  $productRepository, private ManagerRegistry $doctrine)
    {
        $this->entityManager = $this->doctrine->getManager();
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $resJSON = [];
        $productReceivedCodes = $data->getProductCodes();

        if (empty($productReceivedCodes)) {
            throw new BadRequestHttpException("Empty array");
        }

        $warehouse = $this->warehouseRepository->findOneBy(["name" => $data->getName()]);

        if ($warehouse === null) {
            throw new BadRequestHttpException("Warehouse name doesn't exist");
        }
        foreach ($productReceivedCodes as $productReceivedCode) {
            if (gettype($productReceivedCode) !== "string") {
                $resJSON[] = ["productCode"=>$productReceivedCode,"status"=>"wrong variable type"];
                continue;
            }
            $product = $this->productRepository->findOneBy(["productCode" => $productReceivedCode]);
//            Проверка на существование
            if ($product === null) {
                $resJSON[] = ["productCode" => $productReceivedCode, "status" => "error"];
                continue;
            }
//            Проверка на количество
            if ($product->getQuantity() <= 0) {
                $resJSON[] = ["productCode" => $productReceivedCode, "status" => "error"];
                continue;
            }
            $newReserveProduct = new ReservedProduct();
            $newReserveProduct->setWarehouse($warehouse);
            $newReserveProduct->setProductCode($productReceivedCode);
            $this->persistProcessor->process($newReserveProduct, $operation);
            $product->setQuantity($product->getQuantity() - 1);
            $this->entityManager->flush();
            $resJSON[] = ["productCode" => $productReceivedCode, "status" => "success"];
        }

        return $resJSON;
    }
}
