<?php

namespace App\Command\VisualProduction;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualProductionRepository;
use App\Repository\VisualProductionOptionRepository;
use App\Entity\VisualProduction;
use App\Entity\VisualProductionOption;

final class CreateVisualProductionCommandHandler implements CommandHandlerInterface
{
    /** @var  VisualProductionRepository */
    private $visualProductionRepository;

    /** @var VisualProductionOptionRepository */
    private $visualProductionOptionRepository;

    /**
     * VisualProductionCommandHandler constructor.
     *
     * @param VisualProductionRepository $visualProductionRepository
     * @param VisualProductionOptionRepository $visualProductionOptionRepository
     */
    public function __construct(VisualProductionRepository $visualProductionRepository, VisualProductionOptionRepository $visualProductionOptionRepository)
    {
        $this->visualProductionRepository = $visualProductionRepository;
        $this->visualProductionOptionRepository = $visualProductionOptionRepository;
    }

    public function __invoke(CreateVisualProductionCommand $command): void
    {
        $case = new VisualProduction();

        $case->setName($command->getName());
        $case->setEnabled(true);

        foreach ($command->getShapes() as $shape) {
            $optionOb = new VisualProductionOption();
            $optionOb->setName($shape->name);
            $optionOb->setValue($shape->value);
            $optionOb->setDataKey($shape->key);
            $optionOb->setType("shapes");
            $this->visualProductionOptionRepository->persist($optionOb);
            $case->addOption($optionOb);
        }

        foreach ($command->getColors() as $color) {
            $optionOb = new VisualProductionOption();
            $optionOb->setName($color->name);
            $optionOb->setValue($color->value);
            $optionOb->setDataKey($color->key);
            $optionOb->setType("colors");
            $this->visualProductionOptionRepository->persist($optionOb);
            $case->addOption($optionOb);
        }

        $this->visualProductionRepository->save($case);
    }
}
