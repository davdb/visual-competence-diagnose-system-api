<?php

namespace App\Repository;

use App\Entity\VisualPerceptionAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualPerceptionAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualPerceptionAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualPerceptionAnswer[]    findAll()
 * @method VisualPerceptionAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualPerceptionAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualPerceptionAnswer::class);
    }

    // /**
    //  * @return VisualPerceptionAnswer[] Returns an array of VisualPerceptionAnswer objects
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
    public function findOneBySomeField($value): ?VisualPerceptionAnswer
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
