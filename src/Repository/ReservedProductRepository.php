<?php

namespace App\Repository;

use App\Entity\ReservedProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReservedProduct>
 *
 * @method ReservedProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservedProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservedProduct[]    findAll()
 * @method ReservedProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservedProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservedProduct::class);
    }

//    /**
//     * @return ReservedProducts[] Returns an array of ReservedProducts objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReservedProducts
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
