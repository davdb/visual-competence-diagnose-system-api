<?php

namespace App\Command\VisualProduction;

use App\Common\CommandInterface;

final class EditVisualProductionCommand implements CommandInterface
{
    private $id;
    private $name;
    private $shapes = [];
    private $colors = [];

    public function __construct(
        string $id,
        string $name,
        $shapes,
        $colors
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->shapes = $shapes;
        $this->colors = $colors;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getShapes()
    {
        return $this->shapes;
    }
    public function getColors()
    {
        return $this->colors;
    }
}
