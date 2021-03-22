<?php

namespace App\Command\User;

use App\Common\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $age;

    /**
     * CreateUserCommand constructor.
     * @param string $email
     * @param string $password
     * @param string $age
     */
    public function __construct(string $email, string $age, string $plainPassword)
    {
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getAge(): string
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}
