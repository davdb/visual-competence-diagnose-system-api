<?php

namespace App\Entity;

use App\Repository\VisualReceptionAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;


/**
 * @ORM\Entity(repositoryClass=VisualReceptionAnswerRepository::class)
 * @ORM\Table(name="vsco_tc3_visual_reception_answers")
 */
class VisualReceptionAnswer
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Test", inversedBy="visualReceptionAnswers")
     */
    protected $test;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisualReception")
     */
    protected $question;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="float", options={"default" : 0})
     */
    private $value;



    public function getId()
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    public function getQuestion(): ?VisualReception
    {
        return $this->question;
    }

    public function setQuestion(?VisualReception $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
