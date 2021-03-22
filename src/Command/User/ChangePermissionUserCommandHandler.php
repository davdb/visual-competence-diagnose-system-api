<?php

namespace App\Command\User;

use App\Common\CommandHandlerInterface;
use App\Repository\UserRepository;
use App\Entity\User;


final class ChangePermissionUserCommandHandler implements CommandHandlerInterface
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

    public function __invoke(ChangePermissionUserCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getId()]);
        $user->setRoles($command->getRole());

        $this->userRepository->save($user);
    }
}
