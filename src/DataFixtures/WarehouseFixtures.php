<?php

namespace App\DataFixtures;

use App\Entity\Warehouse;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;

class WarehouseFixtures extends Fixture
{
    public const MAIN_WAREHOUSE_ID = 'Rostov-1';

    public function load(ObjectManager $manager): void
    {
        $warehouse = new Warehouse();
        $warehouse->setName("Rostov-1");
        $warehouse->setIsAvailable(true);
        $manager->persist($warehouse);
        $manager->flush();

        $this->addReference(self::MAIN_WAREHOUSE_ID, $warehouse);
    }
}
