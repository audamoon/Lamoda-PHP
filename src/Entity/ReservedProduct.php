<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\State\ProductReservationProcessor;
use App\Repository\ReservedProductRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservedProductRepository::class)]
//#[ApiResource(
//    description: 'Resource for reserve and return',
//    operations: [
//        new Post(
//            uriTemplate: "/product/reserve"
//        ),
//    ],
//    normalizationContext: ['groups' => ['reserve:read']],
//    denormalizationContext: ['groups' => ['reserve:write']]
//)]
class ReservedProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $productCode = null;

    #[ORM\ManyToOne(inversedBy: 'reservedProduct')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Warehouse $warehouse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(string $productCode): static
    {
        $this->productCode = $productCode;

        return $this;
    }

    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(?Warehouse $warehouse): static
    {
        $this->warehouse = $warehouse;

        return $this;
    }

}
