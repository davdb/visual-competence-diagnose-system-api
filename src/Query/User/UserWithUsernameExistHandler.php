<?php

namespace App\Query\User;

use App\Common\QueryHandlerInterface;
use App\Repository\UserRepository;

final class UserWithUsernameExistHandler implements QueryHandlerInterface
{
    /** @var  UserRepository */
    private $userRepository;

    /**
     *
     * @param UserRepository $userRepository
     *
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function __invoke(UserWithUsernameExistQuery $query): bool
    {
        $result = $this->userRepository->findOneBy(['email' => $query->getUsername()]);

        return ($result ? true : false);
    }
}
