<?php

namespace App\Entity;

use App\Repository\VisualPerceptionAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass=VisualPerceptionAnswerRepository::class)
 * @ORM\Table(name="vsco_tc1_visual_perception_answers")
 */
class VisualPerceptionAnswer
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Test", inversedBy="visualPerceptionAnswers")
     */
    protected $test;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisualPerception")
     */
    protected $question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisualPerceptionOption")
     */
    protected $answer;

    public function getId()
    {
        return $this->id;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getQuestion(): ?VisualPerception
    {
        return $this->question;
    }

    public function setQuestion(?VisualPerception $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?VisualPerceptionOption
    {
        return $this->answer;
    }

    public function setAnswer(?VisualPerceptionOption $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
