<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 * @ORM\Table(name="vsco_tests")
 */
class Test
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
     * @ORM\OneToMany(targetEntity="App\Entity\VisualPerceptionAnswer", mappedBy="test", cascade={"persist"})
     */
    private $visualPerceptionAnswers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisualProductionAnswer", mappedBy="test", cascade={"persist"})
     */
    private $visualProductionAnswers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisualReceptionAnswer", mappedBy="test", cascade={"persist"})
     */
    private $visualReceptionAnswers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    protected $owner;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $perceptionPoints;
    /**
     * @ORM\Column(type="float")
     */
    private $productionPoints;
    /**
     * @ORM\Column(type="float")
     */
    private $receptionPoints;

    /**
     * @ORM\Column(type="float")
     */
    private $maxPerceptionPoints;

    /**
     * @ORM\Column(type="float")
     */
    private $maxReceptionPoints;

    /**
     * @ORM\Column(type="float")
     */
    private $maxProductionPoints;

    public function __construct()
    {
        $this->visualPerceptionAnswers = new ArrayCollection();
        $this->visualProductionAnswers = new ArrayCollection();
        $this->visualReceptionAnswers = new ArrayCollection();
        $this->maxPerceptionPoints = 0;
        $this->maxReceptionPoints = 0;
        $this->maxProductionPoints = 0;
        $this->perceptionPoints = 0;
        $this->productionPoints = 0;
        $this->receptionPoints = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProductionPoints(): ?float
    {
        return $this->productionPoints;
    }

    public function setProductionPoints(float $productionPoints): self
    {
        $this->productionPoints = $productionPoints;

        return $this;
    }
    public function getPerceptionPoints(): ?float
    {
        return $this->perceptionPoints;
    }

    public function setPerceptionPoints(float $perceptionPoints): self
    {
        $this->perceptionPoints = $perceptionPoints;

        return $this;
    }
    public function getReceptionPoints(): ?float
    {
        return $this->receptionPoints;
    }

    public function setReceptionPoints(float $receptionPoints): self
    {
        $this->receptionPoints = $receptionPoints;

        return $this;
    }

    /**
     * @return Collection|VisualPerceptionAnswer[]
     */
    public function getVisualPerceptionAnswers(): Collection
    {
        return $this->visualPerceptionAnswers;
    }

    public function addVisualPerceptionAnswer(VisualPerceptionAnswer $visualPerceptionAnswer): self
    {
        if (!$this->visualPerceptionAnswers->contains($visualPerceptionAnswer)) {
            $this->visualPerceptionAnswers[] = $visualPerceptionAnswer;
            $visualPerceptionAnswer->setTest($this);
        }

        return $this;
    }

    public function removeVisualPerceptionAnswer(VisualPerceptionAnswer $visualPerceptionAnswer): self
    {
        if ($this->visualPerceptionAnswers->removeElement($visualPerceptionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($visualPerceptionAnswer->getTest() === $this) {
                $visualPerceptionAnswer->setTest(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|VisualProductionAnswer[]
     */
    public function getVisualProductionAnswers(): Collection
    {
        return $this->visualProductionAnswers;
    }

    public function addVisualProductionAnswer(VisualProductionAnswer $visualProductionAnswer): self
    {
        if (!$this->visualProductionAnswers->contains($visualProductionAnswer)) {
            $this->visualProductionAnswers[] = $visualProductionAnswer;
            $visualProductionAnswer->setTest($this);
        }

        return $this;
    }

    public function removeVisualProductionAnswer(VisualProductionAnswer $visualProductionAnswer): self
    {
        if ($this->visualProductionAnswers->removeElement($visualProductionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($visualProductionAnswer->getTest() === $this) {
                $visualProductionAnswer->setTest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VisualReceptionAnswer[]
     */
    public function getVisualReceptionAnswers(): Collection
    {
        return $this->visualReceptionAnswers;
    }

    public function addVisualReceptionAnswer(VisualReceptionAnswer $visualReceptionAnswer): self
    {
        if (!$this->visualReceptionAnswers->contains($visualReceptionAnswer)) {
            $this->visualReceptionAnswers[] = $visualReceptionAnswer;
            $visualReceptionAnswer->setTest($this);
        }

        return $this;
    }

    public function removeVisualReceptionAnswer(VisualReceptionAnswer $visualReceptionAnswer): self
    {
        if ($this->visualReceptionAnswers->removeElement($visualReceptionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($visualReceptionAnswer->getTest() === $this) {
                $visualReceptionAnswer->setTest(null);
            }
        }

        return $this;
    }

    public function getMaxPerceptionPoints(): ?float
    {
        return $this->maxPerceptionPoints;
    }

    public function setMaxPerceptionPoints(float $maxPerceptionPoints): self
    {
        $this->maxPerceptionPoints = $maxPerceptionPoints;

        return $this;
    }

    public function getMaxReceptionPoints(): ?float
    {
        return $this->maxReceptionPoints;
    }

    public function setMaxReceptionPoints(float $maxReceptionPoints): self
    {
        $this->maxReceptionPoints = $maxReceptionPoints;

        return $this;
    }

    public function getMaxProductionPoints(): ?float
    {
        return $this->maxProductionPoints;
    }

    public function setMaxProductionPoints(float $maxProductionPoints): self
    {
        $this->maxProductionPoints = $maxProductionPoints;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
