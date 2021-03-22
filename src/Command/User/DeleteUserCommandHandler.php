<?php

namespace App\Command\User;

use App\Common\CommandHandlerInterface;
use App\Repository\UserRepository;
use App\Entity\User;


final class DeleteUserCommandHandler implements CommandHandlerInterface
{
    /** @var  UserRepository */
    private $userRepository;


    /**
     * DeleteUserCommandHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getId()]);

        $this->userRepository->delete($user);
    }
}
