<?php

namespace App\Repository;

use App\Entity\VisualProduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Common\TestCaseInterface;


/**
 * @method VisualProduction|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualProduction|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualProduction[]    findAll()
 * @method VisualProduction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualProductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualProduction::class);
    }

    // /**
    //  * @return VisualProduction[] Returns an array of VisualProduction objects
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
    public function findOneBySomeField($value): ?VisualProduction
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getAllVisualProductionTasks()
    {
        $output = [];
        foreach ($this->findBy(['enabled' => true]) as $task) {
            $output[] = [
                "id" => $task->getId(),
                "name" => $task->getName()
            ];
        }

        return $output;
    }


    public function getTaskById($id)
    {
        $task = $this->findOneBy(['id' => $id]);

        $shapes = [];
        $colors = [];

        foreach ($task->getOptions() as $option) {
            if ($option->getType() == "shapes") {
                $shapes[] = [
                    "id" => $option->getId(),
                    "name" => $option->getName(),
                    "value" => $option->getValue(),
                    "type" => $option->getType()
                ];
            } else if ($option->getType() == "colors") {
                $colors[] = [
                    "id" => $option->getId(),
                    "name" => $option->getName(),
                    "value" => $option->getValue(),
                    "type" => $option->getType()
                ];
            }
        }

        return [
            "id" => $task->getId(),
            "name" => $task->getName(),
            "options" => [
                'shapes' => $shapes,
                'colors' => $colors
            ]
        ];
    }


    public function save(TestCaseInterface $case)
    {
        $this->_em->persist($case);
        $this->_em->flush();
    }
}
