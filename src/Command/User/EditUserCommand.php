<?php

namespace App\Command\User;

use App\Common\CommandInterface;

final class EditUserCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $group;

    /**
     * EditUserCommand constructor.
     * @param string $id
     * @param string $email
     * @param string $group
     */
    public function __construct(string $id, string $email, string $group)
    {
        $this->email = $email;
        $this->id = $id;
        $this->group = $group;
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
    public function getId(): string
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }
}
