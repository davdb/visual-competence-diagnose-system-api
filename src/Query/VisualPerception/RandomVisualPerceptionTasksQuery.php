<?php

namespace App\Query\VisualPerception;

use App\Common\QueryInterface;


final class RandomVisualPerceptionTasksQuery implements QueryInterface
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }
}
