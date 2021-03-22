<?php

namespace App\Entity;

use App\Common\TestCaseOptionInterface;
use App\Repository\VisualPerceptionOptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass=VisualPerceptionOptionRepository::class)
 * @ORM\Table(name="vsco_tc1_visual_perception_options")
 */
class VisualPerceptionOption implements TestCaseOptionInterface
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
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisualPerception", inversedBy="options")
     */
    protected $case;


    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $enabled;

    public function getId()
    {
        return $this->id;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getCase(): ?VisualPerception
    {
        return $this->case;
    }

    public function setCase(?VisualPerception $case): self
    {
        $this->case = $case;

        return $this;
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

    public function getValue(): ?bool
    {
        return $this->value;
    }

    public function setValue(bool $value): self
    {
        $this->value = $value;

        return $this;
    }
}
