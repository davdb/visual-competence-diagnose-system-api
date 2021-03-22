<?php

namespace App\Command\User;

use App\Common\CommandHandlerInterface;
use App\Repository\UserRepository;
use App\Entity\User;


final class ChangeEnableUserCommandHandler implements CommandHandlerInterface
{
    /** @var  UserRepository */
    private $userRepository;


    /**
     * ChangeEnableUserCommandHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ChangeEnableUserCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getId()]);
        $user->setEnabled(!$user->getEnabled());

        $this->userRepository->save($user);
    }
}
