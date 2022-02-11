<?php

namespace App\Repository;

use App\Entity\MotorCar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotorCar|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotorCar|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotorCar[]    findAll()
 * @method MotorCar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotorCarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotorCar::class);
    }

    // /**
    //  * @return MotorCar[] Returns an array of MotorCar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MotorCar
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
