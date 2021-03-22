<?php

namespace App\Repository;

use App\Entity\VisualReceptionOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualReceptionOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualReceptionOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualReceptionOption[]    findAll()
 * @method VisualReceptionOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualReceptionOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualReceptionOption::class);
    }

    // /**
    //  * @return VisualReceptionOption[] Returns an array of VisualReceptionOption objects
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
    public function findOneBySomeField($value): ?VisualReceptionOption
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function persist(VisualReceptionOption $option)
    {
        $this->_em->persist($option);
    }
}
