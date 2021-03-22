<?php

namespace App\Command\VisualProduction;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualProductionRepository;
use App\Repository\VisualProductionOptionRepository;
use App\Entity\VisualProduction;
use App\Entity\VisualProductionOption;

final class EditVisualProductionCommandHandler implements CommandHandlerInterface
{
    /** @var  VisualProductionRepository */
    private $visualProductionRepository;

    /** @var VisualProductionOptionRepository */
    private $visualProductionOptionRepository;

    /**
     * EditVisualProductionCommandHandler constructor.
     *
     * @param VisualProductionRepository $visualProductionRepository
     * @param VisualProductionOptionRepository $visualProductionOptionRepository
     */
    public function __construct(VisualProductionRepository $visualProductionRepository, VisualProductionOptionRepository $visualProductionOptionRepository)
    {
        $this->visualProductionRepository = $visualProductionRepository;
        $this->visualProductionOptionRepository = $visualProductionOptionRepository;
    }

    public function __invoke(EditVisualProductionCommand $command): void
    {
        $case = $this->visualProductionRepository->findOneBy(['id' => $command->getId()]);

        if ($case->getName() != $command->getName()) {
            $case->setName($command->getName());
        }

        foreach ($command->getShapes() as $shape) {
            if (isset($shape->id)) {
                $optionOb = $this->visualProductionOptionRepository->findOneBy(['id' => $shape->id]);
                if ($optionOb->getValue() != $shape->value) {
                    $optionOb->setValue($shape->value);
                }
                $this->visualProductionOptionRepository->persist($optionOb);
            }
        }

        foreach ($command->getColors() as $color) {
            if (isset($color->id)) {
                $optionOb = $this->visualProductionOptionRepository->findOneBy(['id' => $color->id]);
                if ($optionOb->getValue() != $color->value) {
                    $optionOb->setValue($color->value);
                }
                $this->visualProductionOptionRepository->persist($optionOb);
            }
        }

        $this->visualProductionRepository->save($case);
    }
}
