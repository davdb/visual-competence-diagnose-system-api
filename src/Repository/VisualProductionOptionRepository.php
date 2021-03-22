<?php

namespace App\Repository;

use App\Entity\VisualProductionOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualProductionOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualProductionOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualProductionOption[]    findAll()
 * @method VisualProductionOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualProductionOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualProductionOption::class);
    }

    // /**
    //  * @return VisualProductionOption[] Returns an array of VisualProductionOption objects
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
    public function findOneBySomeField($value): ?VisualProductionOption
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function persist(VisualProductionOption $option)
    {
        $this->_em->persist($option);
    }
}
