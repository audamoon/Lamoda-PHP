<?php

namespace App\Factory;

use App\Entity\Warehouse;
use App\Repository\WarehouseRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Warehouse>
 *
 * @method        Warehouse|Proxy                     create(array|callable $attributes = [])
 * @method static Warehouse|Proxy                     createOne(array $attributes = [])
 * @method static Warehouse|Proxy                     find(object|array|mixed $criteria)
 * @method static Warehouse|Proxy                     findOrCreate(array $attributes)
 * @method static Warehouse|Proxy                     first(string $sortedField = 'id')
 * @method static Warehouse|Proxy                     last(string $sortedField = 'id')
 * @method static Warehouse|Proxy                     random(array $attributes = [])
 * @method static Warehouse|Proxy                     randomOrCreate(array $attributes = [])
 * @method static WarehouseRepository|RepositoryProxy repository()
 * @method static Warehouse[]|Proxy[]                 all()
 * @method static Warehouse[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Warehouse[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Warehouse[]|Proxy[]                 findBy(array $attributes)
 * @method static Warehouse[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Warehouse[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class WarehouseFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'isAvailable' => self::faker()->boolean(),
            'name' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Warehouse $warehouse): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Warehouse::class;
    }
}
