<?php

namespace App\Command\VisualPerception;

use App\Common\CommandInterface;

final class EditVisualPerceptionCommand implements CommandInterface
{
    private $id;
    private $name;
    private $fileName;
    private $options = [];

    public function __construct(
        string $id,
        string $name,
        $fileName,
        $options
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->fileName = $fileName;
        $this->options = $options;
    }

    public function getId()
    {
        return $this->id;
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
