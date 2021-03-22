<?php

namespace App\Query\User;

use App\Common\QueryHandlerInterface;
use App\Repository\UserRepository;

final class UserWithEmailExistHandler implements QueryHandlerInterface
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
    public function __invoke(UserWithEmailExistQuery $query): bool
    {
        $result = $this->userRepository->findOneBy(['email' => $query->getEmail()]);

        return ($result ? true : false);
    }
}
