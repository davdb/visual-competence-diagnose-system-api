<?php

namespace App\Command\VisualPerception;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualPerceptionRepository;
use App\Repository\VisualPerceptionOptionRepository;
use App\Entity\VisualPerceptionOption;

final class EditVisualPerceptionCommandHandler implements CommandHandlerInterface
{
    /** @var  VisualPerceptionRepository */
    private $visualPerceptionRepository;

    /** @var VisualPerceptionOptionRepository */
    private $visualPerceptionOptionRepository;

    /**
     * EditVisualPerceptionCommandHandler constructor.
     *
     * @param VisualPerceptionRepository $visualPerceptionRepository
     * @param VisualPerceptionOptionRepository $visualPerceptionOptionRepository
     */
    public function __construct(VisualPerceptionRepository $visualPerceptionRepository, VisualPerceptionOptionRepository $visualPerceptionOptionRepository)
    {
        $this->visualPerceptionRepository = $visualPerceptionRepository;
        $this->visualPerceptionOptionRepository = $visualPerceptionOptionRepository;
    }

    public function __invoke(EditVisualPerceptionCommand $command): void
    {
        $case = $this->visualPerceptionRepository->findOneBy(['id' => $command->getId()]);

        if ($case->getName() != $command->getName()) {
            $case->setName($command->getName());
        }
        if ($case->getFile() != $command->getFileName() && $command->getFileName() != "") {
            $case->setFile($command->getFileName());
        }

        $optionsInObject = $case->getOptions();
        $optionsInObjectIds = [];

        foreach ($optionsInObject as $optionOb) {
            $optionsInObjectIds[] = $optionOb->getId();
        }

        foreach ($command->getOptions() as $option) {

            if (isset($option->id) && count($optionsInObjectIds) > 0) {
                if (in_array($option->id, $optionsInObjectIds)) {
                    $optionOb = $this->visualPerceptionOptionRepository->findOneBy(['id' => $option->id]);
                    if ($optionOb->getContent() != $option->name) {
                        $optionOb->setContent($option->name);
                    }
                    if ($optionOb->getValue() != $option->value) {
                        $optionOb->setValue($option->value);
                    }

                    $this->visualPerceptionOptionRepository->persist($optionOb);

                    if (($key = array_search($option->id, $optionsInObjectIds)) !== false) {
                        unset($optionsInObjectIds[$key]);
                    }
                }
            } else {
                $optionOb = new VisualPerceptionOption();
                $optionOb->setContent($option->name);
                $optionOb->setValue($option->value);
                $optionOb->setEnabled(true);
                $this->visualPerceptionOptionRepository->persist($optionOb);
                $case->addOption($optionOb);
            }
        }

        if (count($optionsInObjectIds) > 0) {
            foreach ($optionsInObjectIds as $optionId) {
                $optionOb = $this->visualPerceptionOptionRepository->findOneBy(['id' => $optionId]);
                $optionOb->setEnabled(false);
                $this->visualPerceptionOptionRepository->persist($optionOb);
            }
        }

        $this->visualPerceptionRepository->save($case);
    }
}
