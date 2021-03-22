<?php

namespace App\Command\VisualProduction;

use App\Common\CommandInterface;

final class CreateVisualProductionCommand implements CommandInterface
{
    private $name;
    private $shapes = [];
    private $colors = [];

    public function __construct(
        string $name,
        $shapes,
        $colors
    ) {
        $this->name = $name;
        $this->shapes = $shapes;
        $this->colors = $colors;
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
