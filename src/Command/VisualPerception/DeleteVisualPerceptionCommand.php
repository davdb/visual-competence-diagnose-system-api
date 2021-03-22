<?php

namespace App\Command\VisualPerception;

use App\Common\CommandInterface;

final class DeleteVisualPerceptionCommand implements CommandInterface
{
    private $id;

    public function __construct(
        string $id
    ) {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
