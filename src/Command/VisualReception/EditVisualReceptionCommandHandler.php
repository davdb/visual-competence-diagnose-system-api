<?php

namespace App\Command\VisualReception;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualReceptionRepository;
use App\Repository\VisualReceptionOptionRepository;
use App\Entity\VisualReception;
use App\Entity\VisualReceptionOption;

final class EditVisualReceptionCommandHandler implements CommandHandlerInterface
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

    public function __invoke(EditVisualReceptionCommand $command): void
    {
        $case = $this->visualReceptionRepository->findOneBy(['id' => $command->getId()]);

        if ($case->getName() != $command->getName()) {
            $case->setName($command->getName());
        }

        if ($case->getFile() != $command->getFileName() && $command->getFileName() != "") {
            $case->setFile($command->getFileName());
        }

        foreach ($command->getOptions() as $option) {
            $optionOb = $this->visualReceptionOptionRepository->findOneBy(['id' => $option->id]);
            if ($optionOb->getContent() != $option->content) {
                $optionOb->setContent($option->content);
            }
            $this->visualReceptionOptionRepository->persist($optionOb);
        }

        $this->visualReceptionRepository->save($case);
    }
}
