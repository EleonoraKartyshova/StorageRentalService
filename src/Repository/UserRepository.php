<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user)
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findOneByEmail($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByFacebookID($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.facebookID = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function hasEmptyFieldsById($value)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT 
        (
            IF(email IS NULL OR email='', 1, 0) + 
            IF(company_title IS NULL OR company_title='', 1, 0) + 
            IF(phone_number IS NULL OR phone_number='', 1, 0) + 
            IF(address IS NULL OR address='', 1, 0)
        ) as empty_fields_count
        FROM user 
        WHERE id=". $value;

        $query = $connection->prepare($sql);
        $query->execute();
        $res = $query->fetch(\Doctrine\DBAL\FetchMode::NUMERIC);

        $count = $res[0];

        return (bool) $count;
    }
}
