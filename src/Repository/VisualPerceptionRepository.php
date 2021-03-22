<?php

namespace App\Repository;

use App\Common\TestCaseInterface;
use App\Entity\VisualPerception;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualPerception|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualPerception|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualPerception[]    findAll()
 * @method VisualPerception[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualPerceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualPerception::class);
    }


    public function getTaskById($id, $path)
    {
        $task = $this->findOneBy(['id' => $id]);

        $options = [];
        foreach ($task->getOptions() as $option) {
            if ($option->getEnabled()) {
                $options[] = [
                    "id" => $option->getId(),
                    "name" => $option->getContent(),
                    "value" => $option->getValue(),
                    "checked" => ($option->getValue() ? true : false)
                ];
            }
        }

        return [
            "id" => $task->getId(),
            "name" => $task->getName(),
            "image" => $path . '/' . $task->getFile(),
            "enabled" => $task->getEnabled(),
            "options" => $options
        ];
    }

    public function getAllVisualPerceptionTasks()
    {
        $output = [];
        foreach ($this->findBy(['enabled' => true]) as $task) {
            $output[] = [
                "id" => $task->getId(),
                "name" => $task->getName(),
                "enabled" => $task->getEnabled()
            ];
        }

        return $output;
    }

    public function save(TestCaseInterface $case)
    {
        $this->_em->persist($case);
        $this->_em->flush();
    }
}
