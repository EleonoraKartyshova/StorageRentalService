<?php

namespace App\Repository;

use App\Entity\GoodsProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GoodsProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoodsProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoodsProperty[]    findAll()
 * @method GoodsProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoodsPropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GoodsProperty::class);
    }

    // /**
    //  * @return GoodsProperty[] Returns an array of GoodsProperty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GoodsProperty
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
