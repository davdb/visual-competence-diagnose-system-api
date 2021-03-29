<?php

namespace App\Repository;

use App\Entity\Test;
use App\Entity\VisualPerceptionAnswer;
use App\Entity\VisualReceptionAnswer;
use App\Entity\VisualProductionAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Test|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test[]    findAll()
 * @method Test[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }

    public function getAllTests()
    {
        $output = [];


        foreach ($this->findBy([], ["createdAt" => 'desc']) as $test) {

            $perceptionPoints = $test->getPerceptionPoints();
            $productionPoints = $test->getProductionPoints();
            $receptionPoints = $test->getReceptionPoints();

            $perceptionMaxPoints = $test->getMaxPerceptionPoints();
            $productionMaxPoints = $test->getMaxProductionPoints();
            $receptionMaxPoints = $test->getMaxReceptionPoints();

            $output[] = [
                "id" => $test->getId(),
                "owner" => $test->getOwner()->getEmail(),
                "createdAt" => ($test->getCreatedAt() ? $test->getCreatedAt()->format("d.m.Y") : ""),
                "perceptionPoints" => round(floatval($perceptionPoints / ($perceptionMaxPoints ? $perceptionMaxPoints : 1)) * 100, 2) . "% (" . $perceptionPoints . "/" . $perceptionMaxPoints . ")",
                "receptionPoints" => round(floatval($receptionPoints / ($receptionMaxPoints ? $receptionMaxPoints : 1)) * 100, 2) . "% (" . $receptionPoints . "/" . $receptionMaxPoints . ")",
                "productionPoints" => round(floatval($productionPoints / ($perceptionMaxPoints ? $productionMaxPoints : 1)) * 100, 2) . "% (" . $productionPoints . "/" . $productionMaxPoints . ")",
            ];
        }

        return $output;
    }

    public function getTestById(string $testId, array $arrayWithAssets = [])
    {
        $output = [];
        $test = $this->findOneBy(['id' => $testId]);



        if ($test) {

            $perception = [];

            $perceptionData = $this->_em->getRepository(VisualPerceptionAnswer::class)->findBy(["test" => $test]);

            foreach ($perceptionData as $ob) {

                $taskName = $ob->getQuestion()->getName();
                if (!array_key_exists($taskName, $perception)) {
                    $perception[$taskName] = [];
                }
                $data = ["answer" => $ob->getAnswer()->getContent(), "value" => $ob->getAnswer()->getValue()];

                $perception[$taskName]["answers"][] = $data;

                $file = $arrayWithAssets['perception'] . "/" . $ob->getQuestion()->getFile();

                $type = pathinfo($file, PATHINFO_EXTENSION);
                $data = file_get_contents($file);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                $perception[$taskName]["file"] = $base64;
            }


            $reception = [];

            $receptionData = $this->_em->getRepository(VisualReceptionAnswer::class)->findBy(["test" => $test]);

            foreach ($receptionData as $ob) {

                $file = $arrayWithAssets['reception'] . "/" . $ob->getQuestion()->getFile();

                $type = pathinfo($file, PATHINFO_EXTENSION);
                $data = file_get_contents($file);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                $reception[] = [
                    'name' => $ob->getQuestion()->getName(),
                    'file' => $base64,
                    'answer' => $ob->getContent()

                ];
            }


            $production = [];

            $productionData = $this->_em->getRepository(VisualProductionAnswer::class)->findBy(["test" => $test]);

            foreach ($productionData as $ob) {
                $file = $arrayWithAssets['production'] . "/" . $ob->getFile();

                $type = pathinfo($file, PATHINFO_EXTENSION);
                $data = file_get_contents($file);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                $production[] = [
                    "name" => $ob->getQuestion()->getName(),
                    "file" => $base64
                ];
            }

            $output = [
                "id" => $test->getId(),
                "owner" => $test->getOwner()->getEmail(),
                "createdAt" => ($test->getCreatedAt() ? $test->getCreatedAt()->format("d.m.Y") : ""),
                "perceptionPoints" => $test->getPerceptionPoints(),
                "perceptionMaxPoints" => $test->getMaxPerceptionPoints(),
                "receptionPoints" => $test->getReceptionPoints(),
                "receptionMaxPoints" => $test->getMaxReceptionPoints(),
                "productionPoints" => $test->getProductionPoints(),
                "productionMaxPoints" => $test->getMaxProductionPoints(),
                "perception" => $perception,
                "reception" => $reception,
                "production" => $production
            ];
        }

        return $output;
    }


    public function getTestStatistics()
    {


        $tests = $this->findAll();
        $perception = 0;
        $maxPerception = 0;
        $reception = 0;
        $maxReception = 0;
        $production = 0;
        $maxProduction = 0;
        $counter = count($tests);


        foreach ($tests as $test) {
            $perception += $test->getPerceptionPoints();
            $reception += $test->getReceptionPoints();
            $production += $test->getProductionPoints();
            $maxPerception += $test->getMaxPerceptionPoints();
            $maxReception += $test->getMaxReceptionPoints();
            $maxProduction += $test->getMaxProductionPoints();
        }



        return [
            'perception' => $perception,
            'maxPerception' => $maxPerception,
            'reception' => $reception,
            'maxReception' => $maxReception,
            'production' => $production,
            'maxProduction' => $maxProduction,
            'counter' => $counter
        ];
    }

    public function save(Test $task)
    {
        $this->_em->persist($task);
        $this->_em->flush();
    }
}
