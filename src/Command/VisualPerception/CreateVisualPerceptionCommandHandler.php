<?php

namespace App\Command\VisualPerception;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualPerceptionRepository;
use App\Repository\VisualPerceptionOptionRepository;
use App\Entity\VisualPerception;
use App\Entity\VisualPerceptionOption;

final class CreateVisualPerceptionCommandHandler implements CommandHandlerInterface
{
    /** @var  VisualPerceptionRepository */
    private $visualPerceptionRepository;

    /** @var VisualPerceptionOptionRepository */
    private $visualPerceptionOptionRepository;

    /**
     * VisualPerceptionCommandHandler constructor.
     *
     * @param VisualPerceptionRepository $visualPerceptionRepository
     * @param VisualPerceptionOptionRepository $visualPerceptionOptionRepository
     */
    public function __construct(VisualPerceptionRepository $visualPerceptionRepository, VisualPerceptionOptionRepository $visualPerceptionOptionRepository)
    {
        $this->visualPerceptionRepository = $visualPerceptionRepository;
        $this->visualPerceptionOptionRepository = $visualPerceptionOptionRepository;
    }

    public function __invoke(CreateVisualPerceptionCommand $command): void
    {
        $case = new VisualPerception();

        $case->setName($command->getName());
        $case->setFile($command->getFileName());
        $case->setEnabled(true);
        //dump($command->getFileName());
        foreach ($command->getOptions() as $option) {
            $optionOb = new VisualPerceptionOption();
            $optionOb->setContent($option->name);
            $optionOb->setValue($option->value);
            $optionOb->setEnabled(true);
            $this->visualPerceptionOptionRepository->persist($optionOb);
            $case->addOption($optionOb);
        }

        $this->visualPerceptionRepository->save($case);
    }
}
