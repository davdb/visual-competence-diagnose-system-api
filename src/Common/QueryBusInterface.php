<?php

namespace App\Common;

use App\Common\QueryInterface;

interface QueryBusInterface
{
    /** @return mixed */
    public function handle(QueryInterface $query);
}
