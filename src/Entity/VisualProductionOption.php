<?php

namespace App\Entity;

use App\Repository\VisualProductionOptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;


/**
 * @ORM\Entity(repositoryClass=VisualProductionOptionRepository::class)
 * @ORM\Table(name="vsco_tc2_visual_production_options")
 */
class VisualProductionOption
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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     */
    private $dataKey;


    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisualProduction", inversedBy="options")
     */
    protected $case;


    public function __construct()
    {
        $this->value = 0;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getDataKey(): ?string
    {
        return $this->dataKey;
    }

    public function setDataKey(string $dataKey): self
    {
        $this->dataKey = $dataKey;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCase(): ?VisualProduction
    {
        return $this->case;
    }

    public function setCase(?VisualProduction $case): self
    {
        $this->case = $case;

        return $this;
    }
}
