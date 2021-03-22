<?php

namespace App\Command\User;

use App\Common\CommandHandlerInterface;
use App\Repository\UserRepository;
use App\Entity\User;


final class EditUserCommandHandler implements CommandHandlerInterface
{
    /** @var  UserRepository */
    private $userRepository;



    /**
     * EditUserCommandHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(EditUserCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getId()]);

        if ($user->getEmail() != $command->getEmail()) {
            $user->setEmail($command->getEmail());
        }

        if (!in_array($command->getGroup(), $user->getRoles())) {
            $user->setRoles([$command->getGroup()]);
        }


        $this->userRepository->save($user);
    }
}
