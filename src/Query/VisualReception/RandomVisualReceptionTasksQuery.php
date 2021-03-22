<?php

namespace App\Query\VisualReception;

use App\Common\QueryInterface;


final class RandomVisualReceptionTasksQuery implements QueryInterface
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
