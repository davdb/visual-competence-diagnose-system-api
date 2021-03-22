<?php

namespace App\Command\VisualProduction;

use App\Common\CommandInterface;

final class DeleteVisualProductionCommand implements CommandInterface
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
