<?php

namespace App\Entity;

use App\Common\TestCaseInterface;
use App\Repository\VisualPerceptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;



/**
 * @ORM\Entity(repositoryClass=VisualPerceptionRepository::class)
 * @ORM\Table(name="vsco_tc1_visual_perception")
 */
class VisualPerception implements TestCaseInterface
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
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisualPerceptionOption", mappedBy="case")
     */
    private $options;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|VisualPerceptionOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(VisualPerceptionOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setCase($this);
        }

        return $this;
    }

    public function removeOption(VisualPerceptionOption $option): self
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getCase() === $this) {
                $option->setCase(null);
            }
        }

        return $this;
    }
}
