<?php

namespace App\Query\VisualReception;

use App\Common\QueryHandlerInterface;
use App\Repository\VisualReceptionRepository;

final class RandomVisualReceptionTasksHandler implements QueryHandlerInterface
{

    /** @var  VisualReceptionRepository */
    private $visualReceptionRepository;

    /**
     *
     * @param VisualReceptionRepository $visualReceptionRepository
     *
     */
    public function __construct(VisualReceptionRepository $visualReceptionRepository)
    {
        $this->visualReceptionRepository = $visualReceptionRepository;
    }
    public function __invoke(RandomVisualReceptionTasksQuery $query): array
    {
        $output = [];
        $results = $this->visualReceptionRepository->findAll(['enabled' => true]);

        if ($results) {
            if (count($results) != 1) {
                $resultsArr = array_rand($results, (count($results) > 3 ? 3 : count($results)));
            } else {
                $resultsArr = [0];
            }


            foreach ($resultsArr as $resultArr) {
                $result = $results[$resultArr];
                $data = [
                    "id" => $result->getId(),
                    "content" => $result->getName(),
                    "image" => $query->getPath() . "/" . $result->getFile(),
                    "type" => 'reception',
                ];

                $output[] = $data;
            }
        }

        return $output;
    }
}
