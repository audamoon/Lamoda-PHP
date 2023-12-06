<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ReservedProduct;
use App\Entity\Warehouse;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReservedProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $warehouse = $this->getReference(WarehouseFixtures::MAIN_WAREHOUSE_ID);
        $product = new ReservedProduct();
        $product->setProductCode('0001');
        $product->setWarehouse($warehouse);
        $manager->persist($product);
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            WarehouseFixtures::class
        ];
    }
}
