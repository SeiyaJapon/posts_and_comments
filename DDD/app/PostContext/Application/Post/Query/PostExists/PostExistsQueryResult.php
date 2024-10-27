<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\PostExists;

use App\ShareContext\Application\Query\QueryResultInterface;

class PostExistsQueryResult implements QueryResultInterface
{
    private bool $exists;

    public function __construct(bool $exists)
    {
        $this->exists = $exists;
    }

    public function result(): array
    {
        return [
            'exists' => $this->exists
        ];
    }
}