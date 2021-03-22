<?php

namespace App\Command\VisualReception;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualReceptionRepository;
use App\Repository\VisualReceptionOptionRepository;
use App\Entity\VisualReception;
use App\Entity\VisualReceptionOption;

final class DeleteVisualReceptionCommandHandler implements CommandHandlerInterface
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

    public function __invoke(DeleteVisualReceptionCommand $command): void
    {
        $case = $this->visualReceptionRepository->findOneBy(['id' => $command->getId()]);

        $case->setEnabled(false);

        $this->visualReceptionRepository->save($case);
    }
}
