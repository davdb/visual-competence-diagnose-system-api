<?php

namespace App\Command\User;

use App\Common\CommandInterface;

final class ChangeEnableUserCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;



    /**
     * ChangeEnableUserCommand constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
