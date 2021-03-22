<?php

namespace App\Repository;

use App\Entity\VisualReception;
use App\Common\TestCaseInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualReception|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualReception|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualReception[]    findAll()
 * @method VisualReception[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualReceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualReception::class);
    }

    public function getAllVisualReceptionTasks()
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

    public function getTaskById($id, $path)
    {
        $task = $this->findOneBy(['id' => $id]);

        $options = [];
        foreach ($task->getOptions() as $option) {

            $options[] = [
                "id" => $option->getId(),
                "name" => $option->getName(),
                "content" => $option->getContent()
            ];
        }

        return [
            "id" => $task->getId(),
            "name" => $task->getName(),
            "image" => $path . '/' . $task->getFile(),
            "options" => $options
        ];
    }

    public function save(TestCaseInterface $case)
    {
        $this->_em->persist($case);
        $this->_em->flush();
    }
}
