<?php

namespace App\Repository;

use App\Entity\StorageVolume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StorageVolume|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageVolume|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageVolume[]    findAll()
 * @method StorageVolume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageVolumeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StorageVolume::class);
    }

    // /**
    //  * @return StorageVolume[] Returns an array of StorageVolume objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StorageVolume
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
