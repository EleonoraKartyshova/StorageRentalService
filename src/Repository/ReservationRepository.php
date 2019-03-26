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
        group_concat(IF((r.date_from > '$dateTo'), 0, DATEDIFF((LEAST(r.date_to, '$dateTo')), (GREATEST(r.date_from, '$dateFrom'))))) as tot_days_res_vals,
        DATEDIFF('$dateTo', '$dateFrom') as period,
        (select SUM(count) from storage_volume where storage_type_id=t.id) as storage_count,      
        group_concat(gp.title) as gp_ids,
        MAX(r.created_at) as last_reserved_date,
        group_concat(IF((r.date_to >= CURDATE() AND r.date_from <= CURDATE()), 1, 0)) as is_reserved_now_vals 
        FROM storage_type as t
        LEFT JOIN reservation r 
        ON r.storage_type_id = t.id AND r.created_at>='" . $dateFrom . "' AND r.created_at<='" . $dateTo . "'
        LEFT JOIN goods g 
        ON r.id = g.reservation_id
        LEFT JOIN goods_property as gp 
        ON gp.id = g.goods_property_id       
        GROUP BY t.id
        ";

        $query = $connection->prepare($sql);
        $query->execute();
        $res = $query->fetchAll();

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
