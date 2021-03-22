<?php

namespace App\Command\VisualPerception;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualPerceptionRepository;
use App\Repository\VisualPerceptionOptionRepository;


final class DeleteVisualPerceptionCommandHandler implements CommandHandlerInterface
{
    /** @var  VisualPerceptionRepository */
    private $visualPerceptionRepository;

    /** @var VisualPerceptionOptionRepository */
    private $visualPerceptionOptionRepository;

    /**
     * DeleteVisualPerceptionCommandHandler constructor.
     *
     * @param VisualPerceptionRepository $visualPerceptionRepository
     * @param VisualPerceptionOptionRepository $visualPerceptionOptionRepository
     */
    public function __construct(VisualPerceptionRepository $visualPerceptionRepository, VisualPerceptionOptionRepository $visualPerceptionOptionRepository)
    {
        $this->visualPerceptionRepository = $visualPerceptionRepository;
        $this->visualPerceptionOptionRepository = $visualPerceptionOptionRepository;
    }

    public function __invoke(DeleteVisualPerceptionCommand $command): void
    {
        $case = $this->visualPerceptionRepository->findOneBy(['id' => $command->getId()]);

        $case->setEnabled(false);

        $this->visualPerceptionRepository->save($case);
    }
}
