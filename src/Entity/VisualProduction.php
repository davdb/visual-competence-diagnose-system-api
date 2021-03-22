<?php

namespace App\Entity;

use App\Repository\VisualProductionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Common\TestCaseInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Ramsey\Uuid\Doctrine\UuidGenerator;


/**
 * @ORM\Entity(repositoryClass=VisualProductionRepository::class)
 * @ORM\Table(name="vsco_tc2_visual_production")
 * @UniqueEntity("name")
 */
class VisualProduction implements TestCaseInterface
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisualProductionOption", mappedBy="case")
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
     * @return Collection|VisualProductionOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(VisualProductionOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setCase($this);
        }

        return $this;
    }

    public function removeOption(VisualProductionOption $option): self
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
