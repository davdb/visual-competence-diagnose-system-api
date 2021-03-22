<?php

namespace App\Command\VisualReception;

use App\Common\CommandInterface;

final class DeleteVisualReceptionCommand implements CommandInterface
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
