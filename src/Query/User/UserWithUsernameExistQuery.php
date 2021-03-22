<?php

namespace App\Query\User;

use App\Common\QueryInterface;


final class UserWithUsernameExistQuery implements QueryInterface
{
    private string $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
