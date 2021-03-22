<?php

namespace App\Query\VisualPerception;

use App\Common\QueryHandlerInterface;
use App\Repository\VisualPerceptionRepository;
use App\Repository\VisualPerceptionOptionRepository;

final class RandomVisualPerceptionTasksHandler implements QueryHandlerInterface
{

    /** @var  VisualPerceptionRepository */
    private $visualPerceptionRepository;

    /** @var  VisualPerceptionOptionRepository */
    private $visualPerceptionOptionRepository;


    /**
     *
     * @param VisualPerceptionRepository $visualPerceptionRepository
     * @param VisualPerceptionOptionRepository $visualPerceptionOptionRepository
     *
     */
    public function __construct(VisualPerceptionRepository $visualPerceptionRepository, VisualPerceptionOptionRepository $visualPerceptionOptionRepository)
    {
        $this->visualPerceptionRepository = $visualPerceptionRepository;
        $this->visualPerceptionOptionRepository = $visualPerceptionOptionRepository;
    }
    public function __invoke(RandomVisualPerceptionTasksQuery $query): array
    {
        $output = [];

        $results = $this->visualPerceptionRepository->findAll(['enabled' => true]);

        if ($results) {
            if (count($results) != 1) {
                $resultsArr = array_rand($results, (count($results) > 5 ? 5 : count($results)));
            } else {
                $resultsArr = [0];
            }

            foreach ($resultsArr as $resultArr) {
                $result = $results[$resultArr];
                $data = [
                    "id" => $result->getId(),
                    "content" => $result->getName(),
                    "time" => 25,
                    "image" => $query->getPath() . "/" . $result->getFile(),
                    "type" => 'perception',
                ];

                $options = $this->visualPerceptionOptionRepository->findBy(['case' => $result, 'enabled' => true]);


                if (count($options) > 4) {
                    $randomKeysArr = array_rand($options, 4);
                } else {
                    $randomKeysArr = range(0, count($options) - 1);
                }

                $optionsArray = [];

                foreach ($randomKeysArr as $key) {
                    $option = $options[$key];
                    if ($option->getEnabled()) {
                        $optionsArray[] = [
                            "id" => $option->getId(),
                            "content" => $option->getContent(),
                            "value" => $option->getValue()
                        ];
                    }
                }

                $data['options'] = $optionsArray;

                $output[] = $data;
            }
        }
        return $output;
    }
}
