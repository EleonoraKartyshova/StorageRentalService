<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function getReportByPeriod($dateFrom, $dateTo)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT t.title as storage_title,
        COUNT(r.id) as total_reservations_count,
        SUM(r.date_to - r.date_from) as total_days_reserved,
        group_concat(r.id) as r_ids,
        group_concat(gp.id) as gp_ids,
        MAX(r.created_at) as last_reserved_date,
        IF(MAX(r.date_to) > NOW(), 1, 0) as is_reserved_now 
        FROM storage_type as t 
        JOIN reservation r 
        ON r.storage_type_id = t.id AND r.created_at>='" . $dateFrom . "' AND r.created_at<='" . $dateTo . "'
        LEFT JOIN goods g 
        ON r.id = g.reservation_id
        LEFT JOIN goods_property as gp 
        ON gp.id = g.goods_property_id
        GROUP BY t.id
        
        ";

//        $sql = "
//        SELECT t.title as storage_title,
//        COUNT(r.id) as total_reservations_count,
//        SUM(r.date_to - r.date.from) as total_days_reserved,
//        0 as total_days_empty,
//        0 as most_popular_goods_property,
//        group_concat(r.id) as r_ids,
//        group_concat(gp.id) as gp_ids,
//        MAX(r.created_at) as last_reserved_date,
//        IF(MAX(r.date_to) > NOW(), 1, 0) as is_reserved_now
//        FROM storage_type as t
//        JOIN reservation r
//        ON r.storage_type_id = t.id
//        LEFT JOIN goods g
//        ON r.id = g.reservation_id
//        LEFT JOIN goods_property as gp
//        ON gp.id = g.goods_property_id
//        GROUP BY t.id
//        WHERE r.created_at>='" . $dateFrom . "' AND r.created_at<='" . $dateTo . "'
//        ";

//        $sql = "
//        SELECT *
//        FROM reservation
//
//        WHERE created_at>='" . $dateFrom . "' AND created_at<='" . $dateTo . "'
//        ";

        $query = $connection->prepare($sql);
        //dd($query);
        $query->execute();
        //dd($query);
        $res = $query->fetchAll();
        //dd($res);

        return $res;
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
