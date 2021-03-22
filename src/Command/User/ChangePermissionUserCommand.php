<?php

namespace App\Command\User;

use App\Common\CommandInterface;

final class ChangePermissionUserCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $role;

    /**
     * ChangeEnableUserCommand constructor.
     * @param string $id
     * @param string $role
     */
    public function __construct(string $id, array $role)
    {
        $this->id = $id;
        $this->role = $role;
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
    public function getRole(): array
    {
        return $this->role;
    }
}
