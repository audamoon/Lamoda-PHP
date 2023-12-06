<?php

namespace App\DataFixtures;

use App\Entity\Warehouse;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $namesArr = ["AmericansBeer", "NinjaSwords", "MJShoes", "T-RexShirt", "Boobs", "RoarsMonsters", "Minions"];
        $sizes = ["XS", "S", "M", "L", "XL", "2XL", "3XL", "4XL", "XXXXXL"];
        $warehouse = $this->getReference(WarehouseFixtures::MAIN_WAREHOUSE_ID);
        for ($i = 0; $i < 5; $i++) {
            $product = new Product();
            $product->setName( $namesArr[array_rand($namesArr, 1)] . "-" . $i);
            $product->setSize($sizes[array_rand($sizes, 1)]);
            $product->setProductCode('000' . $i);
            $product->setQuantity(4);
            $product->setWarehouse($warehouse);
            $manager->persist($product);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            WarehouseFixtures::class,
        ];
    }
}
