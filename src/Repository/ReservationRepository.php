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

    public function testrep()
    {
        return "hello";
    }

    public function getReportByPeriod($dateFrom, $dateTo)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT storage_type_id, COUNT(storage_type_id) 
        FROM reservation 
        
        WHERE created_at>='" . $dateFrom . "' AND created_at<='" . $dateTo . "'
        ";


//        SELECT reservation.storage_type_id, goods.goods_property_id
//FROM reservation
//LEFT JOIN goods
//ON (reservation.id=goods.reservation_id)
//WHERE reservation.created_at>='2019-02-18' AND reservation.created_at<='2019-03-18'
//
//
//    SELECT reservation.storage_type_id, goods.goods_property_id, goods_property.title
//FROM reservation
//LEFT JOIN goods
//ON (reservation.id=goods.reservation_id)
//LEFT JOIN goods_property
//ON (goods.goods_property_id=goods_property.id)
//WHERE reservation.created_at>='2019-02-18' AND reservation.created_at<='2019-03-18'
//
//
//    SELECT COUNT(reservation.storage_type_id), goods_property.title, storage_type.title
//FROM reservation
//LEFT JOIN goods
//	ON reservation.id=goods.reservation_id
//LEFT JOIN goods_property
//	ON goods.goods_property_id=goods_property.id
//LEFT JOIN storage_type
//	ON storage_type.id=reservation.storage_type_id
//WHERE reservation.created_at>='2019-02-18' AND reservation.created_at<='2019-03-18';
//
//SELECT t.*, count(r.id)
//FROM storage_type AS t
//join reservation r on r.storage_type_id=t.id
//group by t.id;



//        $sql = "
//        SELECT
//        (
//            IF(email IS NULL OR email='', 1, 0) +
//            IF(company_title IS NULL OR company_title='', 1, 0) +
//            IF(phone_number IS NULL OR phone_number='', 1, 0) +
//            IF(address IS NULL OR address='', 1, 0)
//        ) as empty_fields_count
//        FROM user
//        WHERE id=". $value;

        $query = $connection->prepare($sql);
        dd($query);
        $query->execute();
        dd($query);
        $res = $query->fetchAll();
        dd($res);

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
