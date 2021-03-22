<?php

namespace App\Query\VisualProduction;

use App\Common\QueryHandlerInterface;
use App\Repository\VisualProductionRepository;
use App\Repository\VisualProductionOptionRepository;

final class RandomVisualProductionTasksHandler implements QueryHandlerInterface
{

    /** @var  VisualProductionRepository */
    private $visualProductionRepository;

    /** @var  VisualProductionOptionRepository */
    private $visualProductionOptionRepository;


    /**
     *
     * @param VisualProductionRepository $visualProductionRepository
     * @param VisualProductionOptionRepository $visualPerceptionOptionRepository
     *
     */
    public function __construct(VisualProductionRepository $visualProductionRepository, VisualProductionOptionRepository $visualProductionOptionRepository)
    {
        $this->visualProductionRepository = $visualProductionRepository;
        $this->visualProductionOptionRepository = $visualProductionOptionRepository;
    }
    public function __invoke(RandomVisualProductionTasksQuery $query): array
    {
        $output = [];
        $results = $this->visualProductionRepository->findAll(['enabled' => true]);
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
                    "type" => 'production',
                ];

                $options = $this->visualProductionOptionRepository->findBy(['case' => $result]);

                $optionsShapesArray = [];
                $optionsColorsArray = [];

                foreach ($options as $option) {
                    if ($option->getType() == "shapes") {
                        $optionsShapesArray[] = [
                            "id" => $option->getId(),
                            "name" => $option->getName(),
                            "value" => $option->getValue(),
                            "type" => $option->getType()
                        ];
                    } else if ($option->getType() === "colors") {
                        $optionsColorsArray[] = [
                            "id" => $option->getId(),
                            "name" => $option->getName(),
                            "value" => $option->getValue(),
                            "type" => $option->getType()
                        ];
                    }
                }

                $data['options']['shapes'] = $optionsShapesArray;
                $data['options']['colors'] = $optionsColorsArray;

                $output[] = $data;
            }
        }
        return $output;
    }
}
