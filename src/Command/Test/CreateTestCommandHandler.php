<?php

namespace App\Command\Test;

use App\Common\CommandHandlerInterface;
use App\Repository\VisualPerceptionAnswerRepository;
use App\Repository\VisualPerceptionRepository;
use App\Repository\VisualPerceptionOptionRepository;
use App\Repository\VisualProductionAnswerRepository;
use App\Repository\VisualProductionRepository;
use App\Repository\VisualProductionOptionRepository;
use App\Repository\VisualReceptionAnswerRepository;
use App\Repository\VisualReceptionRepository;
use App\Repository\VisualReceptionOptionRepository;
use App\Repository\TestRepository;
use App\Entity\VisualPerceptionAnswer;
use App\Utils\UploaderService;
use App\Entity\Test;
use App\Entity\VisualProductionAnswer;
use App\Entity\VisualReceptionAnswer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;




final class CreateTestCommandHandler implements CommandHandlerInterface
{

    /** @var  VisualPerceptionRepository */
    private $visualPerceptionRepository;

    /** @var  VisualPerceptionAnswerRepository */
    private $visualPerceptionAnswerRepository;

    /** @var  VisualPerceptionOptionRepository */
    private $visualPerceptionOptionRepository;

    /** @var  VisualProductionRepository */
    private $visualProductionRepository;

    /** @var  VisualProductionAnswerRepository */
    private $visualProductionAnswerRepository;

    /** @var  VisualProductionOptionRepository */
    private $visualProductionOptionRepository;

    /** @var  VisualReceptionRepository */
    private $visualReceptionRepository;

    /** @var  VisualReceptionAnswerRepository */
    private $visualReceptionAnswerRepository;

    /** @var  VisualReceptionOptionRepository */
    private $visualReceptionOptionRepository;

    /** @var  TestRepository  */
    private $testRepository;

    /** @var  TokenStorageInterface */
    private $tokenStorage;

    /** @var  UploaderService */
    private $uploaderService;

    /**
     * CreateUserCommandHandler constructor.
     *
     * @param TestRepository $testRepository
     * @param VisualPerceptionAnswerRepository $visualPerceptionAnswerRepository
     * @param VisualPerceptionRepository $visualPerceptionRepository
     * @param VisualPerceptionOptionRepository $visualPerceptionOptionRepository
     * @param VisualProductionRepository $visualProductionRepository
     * @param VisualProductionAnswerRepository $visualProductionAnswerRepository
     * @param VisualProductionOptionRepository $visualProductionOptionRepository
     * @param VisualReceptionAnswerRepository $visualReceptionAnswerRepository
     * @param VisualReceptionRepository $visualReceptionRepository
     * @param VisualReceptionOptionRepository $visualReceptionOptionRepository
     * @param TokenStorageInterface $tokenStorage
     * @param UploaderService $uploaderService
     */
    public function __construct(
        TestRepository $testRepository,
        VisualPerceptionAnswerRepository $visualPerceptionAnswerRepository,
        VisualPerceptionRepository $visualPerceptionRepository,
        VisualPerceptionOptionRepository $visualPerceptionOptionRepository,
        VisualProductionRepository $visualProductionRepository,
        VisualProductionAnswerRepository $visualProductionAnswerRepository,
        VisualProductionOptionRepository $visualProductionOptionRepository,
        VisualReceptionAnswerRepository $visualReceptionAnswerRepository,
        VisualReceptionRepository $visualReceptionRepository,
        VisualReceptionOptionRepository $visualReceptionOptionRepository,
        TokenStorageInterface $tokenStorage,
        UploaderService $uploaderService
    ) {
        $this->testRepository = $testRepository;
        $this->visualPerceptionAnswerRepository = $visualPerceptionAnswerRepository;
        $this->visualPerceptionRepository = $visualPerceptionRepository;
        $this->visualPerceptionOptionRepository = $visualPerceptionOptionRepository;
        $this->visualProductionRepository = $visualProductionRepository;
        $this->visualProductionAnswerRepository = $visualProductionAnswerRepository;
        $this->visualProductionOptionRepository = $visualProductionOptionRepository;
        $this->visualReceptionAnswerRepository = $visualReceptionAnswerRepository;
        $this->visualReceptionRepository = $visualReceptionRepository;
        $this->visualReceptionOptionRepository = $visualReceptionOptionRepository;
        $this->tokenStorage = $tokenStorage;
        $this->uploaderService = $uploaderService;
    }

    public function __invoke(CreateTestCommand $command)
    {
        $test = new Test();
        $test->setOwner($this->tokenStorage->getToken() ? $this->tokenStorage->getToken()->getUser() : null);

        $perceptionPoints = 0;
        $productionPoints = 0;
        $receptionPoints = 0;

        $maxPerceptionPoints = 0;
        $maxProductionPoints = 0;
        $maxReceptionPoints = 0;

        foreach ($command->getAnswers() as $answer) {

            if ($answer->type === "perception") {
                $task = $this->visualPerceptionRepository->findOneBy(['id' => $answer->task]);
                foreach ($answer->answers as $an) {
                    $answerOb = new VisualPerceptionAnswer();
                    $answerOb->setQuestion($task);
                    $option = $this->visualPerceptionOptionRepository->findOneBy(['id' => $an->id]);
                    $answerOb->setAnswer($option);
                    $perceptionPoints += $option->getValue();
                    if ($option->getValue() === false) $perceptionPoints -= 1;
                    $maxPerceptionPoints += intval(($an->value) ? 1 : 0);
                    $test->addVisualPerceptionAnswer($answerOb);
                }
            } else if ($answer->type == 'reception') {
                $task = $this->visualReceptionRepository->findOneBy(['id' => $answer->task]);
                $options = $task->getOptions();
                $answerOb = new VisualReceptionAnswer();
                $answerOb->setQuestion($task);

                if (is_array($answer->answers)) $answer->answers = "";

                if ($answer->answers != "") {
                    $answerContent = explode(" ", $answer->answers);
                    $optLevArr = 0;
                    $optLevMaxArr = 0;
                    foreach ($options as $opt) {

                        $optLev = 0;
                        $optMaxLev = 0;
                        $optLevWeightsArr = [];
                        $optionContent = explode(" ", $opt->getContent());

                        foreach ($answerContent as $anC) {
                            foreach ($optionContent as $optC) {
                                $lev = levenshtein($anC, $optC);

                                if ($lev > strlen($optC)) {
                                    $optLev += 0;
                                } else if ($lev === 0) {
                                    $optLev += floatval(strlen($optC) * $opt->getValue());
                                } else {
                                    $optLev += floatval(((strlen($optC) - $lev) * $opt->getValue()));
                                }
                                $optMaxLev += floatval(strlen($optC) * $opt->getValue());

                                $optLevWeightsArr[] = intval($opt->getValue());
                            }
                        }
                        $optLevArr += floatval($optLev / (array_sum($optLevWeightsArr)));
                        $optLevMaxArr += floatval($optMaxLev / (array_sum($optLevWeightsArr)));
                    }
                    $answerOb->setValue(round(floatval($optLevArr / (floatval($optLevMaxArr))) * 100), 2);
                    $receptionPoints += round(floatval($optLevArr / (floatval($optLevMaxArr)) * 100), 2);
                } else {
                    $answerOb->setValue(0);
                }

                $maxReceptionPoints += floatval(100);

                $answerOb->setContent($answer->answers);
                $test->addVisualReceptionAnswer($answerOb);
            } else if ($answer->type == 'production') {
                $task = $this->visualProductionRepository->findOneBy(['id' => $answer->task]);
                $answerOb = new VisualProductionAnswer();
                $answerOb->setQuestion($task);

                $options = $task->getOptions();
                $optionsPointsArr = [];

                foreach ($options as $opt) {
                    $optionsPointsArr[strtolower($opt->getDataKey())] = $opt->getValue();
                    $optinsPoints = 0;
                    $maxProductionPoints += ($opt->getValue());
                }


                foreach ($answer->answers->shapes as $part) {
                    $partData = $part[1];
                    if (property_exists($partData, "fill")) {
                        if (array_key_exists(strtolower($partData->fill), $optionsPointsArr)) {
                            $optinsPoints += $optionsPointsArr[strtolower($partData->fill)];
                            unset($optionsPointsArr[strtolower($partData->fill)]);
                        }
                    }
                    if (property_exists($partData, "stroke")) {
                        if (array_key_exists(strtolower($partData->stroke), $optionsPointsArr)) {
                            $optinsPoints += $optionsPointsArr[strtolower($partData->stroke)];
                            unset($optionsPointsArr[strtolower($partData->stroke)]);
                        }
                    }
                    if (property_exists($partData, "type")) {
                        if (array_key_exists(strtolower($partData->type), $optionsPointsArr)) {
                            $optinsPoints += $optionsPointsArr[strtolower($partData->type)];
                            unset($optionsPointsArr[strtolower($partData->type)]);
                        }
                    }
                }


                $fileName = $this->uploaderService->base64ToImage($answer->answers->image, $command->getProductionPath());
                $answerOb->setValue($optinsPoints);
                $productionPoints += $optinsPoints;
                $answerOb->setFile($fileName);

                $test->addVisualProductionAnswer($answerOb);
            }
        }

        $test->setPerceptionPoints($perceptionPoints);
        $test->setProductionPoints($productionPoints);
        $test->setReceptionPoints($receptionPoints);
        $test->setMaxPerceptionPoints($maxPerceptionPoints);
        $test->setMaxProductionPoints($maxProductionPoints);
        $test->setMaxReceptionPoints($maxReceptionPoints);

        $test->setCreatedAt(new \DateTime('now'));

        $this->testRepository->save($test);

        return $test;
    }
}
