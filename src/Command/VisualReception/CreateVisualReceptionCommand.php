<?php

namespace App\Command\VisualReception;

use App\Common\CommandInterface;

final class CreateVisualReceptionCommand implements CommandInterface
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
