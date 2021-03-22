<?php

namespace App\Entity;

use App\Repository\VisualReceptionRepository;
use App\Common\TestCaseInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisualReceptionRepository::class)
 * @ORM\Table(name="vsco_tc3_visual_reception")
 * @UniqueEntity("name")
 */
class VisualReception implements TestCaseInterface
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
     * @ORM\Column(type="string")
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisualReceptionOption", mappedBy="case")
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
     * @return Collection|VisualReceptionOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(VisualReceptionOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setCase($this);
        }

        return $this;
    }

    public function removeOption(VisualReceptionOption $option): self
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
