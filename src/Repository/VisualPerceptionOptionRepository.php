<?php

namespace App\Repository;

use App\Entity\VisualPerception;
use App\Entity\VisualPerceptionOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualPerceptionOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualPerceptionOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualPerceptionOption[]    findAll()
 * @method VisualPerceptionOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualPerceptionOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualPerceptionOption::class);
    }

    public function persist(VisualPerceptionOption $option)
    {
        $this->_em->persist($option);
    }

    // /**
    //  * @return VisualPerceptionOption[] Returns an array of VisualPerceptionOption objects
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
    public function findOneBySomeField($value): ?VisualPerceptionOption
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
