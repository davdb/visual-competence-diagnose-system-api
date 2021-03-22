<?php

namespace App\Query\User;

use App\Common\QueryInterface;


final class UserWithEmailExistQuery implements QueryInterface
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
