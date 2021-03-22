<?php

namespace App\Repository;

use App\Entity\VisualProductionAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualProductionAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualProductionAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualProductionAnswer[]    findAll()
 * @method VisualProductionAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualProductionAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualProductionAnswer::class);
    }

    // /**
    //  * @return VisualProductionAnswer[] Returns an array of VisualProductionAnswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VisualProductionAnswer
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
