<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\WarehouseRepository;
use App\State\ProductRemoveReserveProcessor;
use App\State\ProductReserveProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WarehouseRepository::class)]
#[ApiResource (
    description: 'A place where you store products',
    operations: [
        new GetCollection(),
        new Post(
            uriTemplate: "products/reserve",
            processor: ProductReserveProcessor::class
        ),
        new Post(
            uriTemplate: "products/reserve/remove",
            processor: ProductRemoveReserveProcessor::class
        )
    ],
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['reserve:write']]
)]
class Warehouse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["product:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["product:read", "reserve:write"])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(["product:read"])]
    private ?bool $isAvailable = null;

    #[ORM\OneToMany(mappedBy: 'warehouse', targetEntity: Product::class)]
    private Collection $product;

    #[ORM\OneToMany(mappedBy: 'warehouse', targetEntity: ReservedProduct::class)]
    private Collection $reservedProduct;

    #[Groups(["reserve:write"])]
    private ?array $productCodes = null;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->reservedProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getProductCodes(): ?array
    {
        return $this->productCodes;
    }

    public function setProductCodes(array $productCodes): static
    {
        $this->productCodes = $productCodes;

        return $this;
    }

    #[Groups(["product:read"])]
    public function getProductAmount(): int {
        return count($this->getProduct());
    }
    /**
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
            $product->setWarehouse($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getWarehouse() === $this) {
                $product->setWarehouse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReservedProduct>
     */
    public function getReservedProduct(): Collection
    {
        return $this->reservedProduct;
    }

    public function addReservedProduct(ReservedProduct $reservedProduct): static
    {
        if (!$this->reservedProduct->contains($reservedProduct)) {
            $this->reservedProduct->add($reservedProduct);
            $reservedProduct->setWarehouse($this);
        }

        return $this;
    }

    public function removeReservedProduct(ReservedProduct $reservedProduct): static
    {
        if ($this->reservedProduct->removeElement($reservedProduct)) {
            // set the owning side to null (unless already changed)
            if ($reservedProduct->getWarehouse() === $this) {
                $reservedProduct->setWarehouse(null);
            }
        }

        return $this;
    }
}
