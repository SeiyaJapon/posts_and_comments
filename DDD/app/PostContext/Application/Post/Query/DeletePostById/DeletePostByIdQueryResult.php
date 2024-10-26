<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\DeletePostById;

use App\ShareContext\Application\Query\QueryResultInterface;

class DeletePostByIdQueryResult implements QueryResultInterface
{
    private bool $success;

    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    public function result(): array
    {
        return ['success' => $this->success];
    }
}