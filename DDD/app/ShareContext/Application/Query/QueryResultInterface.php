<?php

declare (strict_types = 1);

namespace App\ShareContext\Application\Query;

interface QueryResultInterface
{
    public function result(): array;
}