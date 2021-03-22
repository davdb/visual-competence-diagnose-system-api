<?php

namespace App\Command\VisualPerception;

use App\Common\CommandInterface;

final class CreateVisualPerceptionCommand implements CommandInterface
{
    private $name;
    private $fileName;
    private $options = [];

    public function __construct(
        string $name,
        $fileName,
        $options
    ) {
        $this->name = $name;
        $this->fileName = $fileName;
        $this->options = $options;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
