<?php

namespace App\Command\User;

use App\Common\CommandHandlerInterface;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


final class CreateUserCommandHandler implements CommandHandlerInterface
{
    /** @var  UserRepository */
    private $userRepository;

    /** @var  UserPasswordEncoderInterface  */
    private $encoder;

    /**
     * CreateUserCommandHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User();
        $user->setEmail($command->getEmail());
        $user->setAge($command->getAge());
        $encodePassword = $this->encoder->encodePassword($user, $command->getPlainPassword());
        $user->setPassword($encodePassword);

        $this->userRepository->save($user);
    }
}
