<?php

namespace App\Command\VisualProduction;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualProductionRepository;
use App\Repository\VisualProductionOptionRepository;
use App\Entity\VisualProduction;
use App\Entity\VisualProductionOption;

final class DeleteVisualProductionCommandHandler implements CommandHandlerInterface
{
    /** @var  VisualProductionRepository */
    private $visualProductionRepository;

    /** @var VisualProductionOptionRepository */
    private $visualProductionOptionRepository;

    /**
     * DeleteVisualProductionCommandHandler constructor.
     *
     * @param VisualProductionRepository $visualProductionRepository
     * @param VisualProductionOptionRepository $visualProductionOptionRepository
     */
    public function __construct(VisualProductionRepository $visualProductionRepository, VisualProductionOptionRepository $visualProductionOptionRepository)
    {
        $this->visualProductionRepository = $visualProductionRepository;
        $this->visualProductionOptionRepository = $visualProductionOptionRepository;
    }

    public function __invoke(DeleteVisualProductionCommand $command): void
    {
        $case = $this->visualProductionRepository->findOneBy(['id' => $command->getId()]);

        $case->setEnabled(false);

        $this->visualProductionRepository->save($case);
    }
}
