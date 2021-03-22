<?php

namespace App\Command\VisualReception;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualReceptionRepository;
use App\Repository\VisualReceptionOptionRepository;
use App\Entity\VisualReception;
use App\Entity\VisualReceptionOption;

final class CreateVisualReceptionCommandHandler implements CommandHandlerInterface
{
    /** @var  VisualReceptionRepository */
    private $visualReceptionRepository;

    /** @var VisualReceptionOptionRepository */
    private $visualReceptionOptionRepository;

    /**
     * VisualReceptionCommandHandler constructor.
     *
     * @param VisualReceptionRepository $visualReceptionRepository
     * @param VisualReceptionOptionRepository $visualReceptionOptionRepository
     */
    public function __construct(VisualReceptionRepository $visualReceptionRepository, VisualReceptionOptionRepository $visualReceptionOptionRepository)
    {
        $this->visualReceptionRepository = $visualReceptionRepository;
        $this->visualReceptionOptionRepository = $visualReceptionOptionRepository;
    }

    public function __invoke(CreateVisualReceptionCommand $command): void
    {
        $case = new VisualReception();

        $case->setName($command->getName());
        $case->setFile($command->getFileName());
        $case->setEnabled(true);
        foreach ($command->getOptions() as $option) {
            $optionOb = new VisualReceptionOption();
            $optionOb->setName($option->name);
            $optionOb->setContent($option->content);
            $optionOb->setValue($option->value);
            $this->visualReceptionOptionRepository->persist($optionOb);
            $case->addOption($optionOb);
        }

        $this->visualReceptionRepository->save($case);
    }
}
