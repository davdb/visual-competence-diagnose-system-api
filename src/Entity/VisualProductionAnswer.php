<?php

namespace App\Entity;

use App\Repository\VisualProductionAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;


/**
 * @ORM\Entity(repositoryClass=VisualProductionAnswerRepository::class)
 * @ORM\Table(name="vsco_tc2_visual_production_answers")
 */
class VisualProductionAnswer
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Test", inversedBy="visualProductionAnswers")
     */
    protected $test;

    /**
     * @ORM\Column(type="string")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisualProduction")
     */
    protected $question;

    /**
     * @ORM\Column(type="float", options={"default" : 0})
     */
    private $value;


    public function getId()
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

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

    public function getQuestion(): ?VisualProduction
    {
        return $this->question;
    }

    public function setQuestion(?VisualProduction $question): self
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
