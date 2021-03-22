<?php

namespace App\Repository;

use App\Entity\VisualReceptionAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualReceptionAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualReceptionAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualReceptionAnswer[]    findAll()
 * @method VisualReceptionAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualReceptionAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualReceptionAnswer::class);
    }

    // /**
    //  * @return VisualReceptionAnswer[] Returns an array of VisualReceptionAnswer objects
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
    public function findOneBySomeField($value): ?VisualReceptionAnswer
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
