<?php

namespace App\Common;

use Symfony\Component\Messenger\MessageBusInterface;
use App\Common\CommandBusInterface;
use App\Common\CommandInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Stamp\HandledStamp;


final class CommandBus implements CommandBusInterface
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(CommandInterface $command)
    {
        $envelope = $this->commandBus->dispatch($command);
        /** @var HandledStamp $handled */
        $handled = $envelope->last(HandledStamp::class);
        return $handled->getResult();
    }
}
