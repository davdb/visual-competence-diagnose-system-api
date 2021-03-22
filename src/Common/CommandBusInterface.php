<?php

namespace App\Common;

use App\Common\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command);
}
