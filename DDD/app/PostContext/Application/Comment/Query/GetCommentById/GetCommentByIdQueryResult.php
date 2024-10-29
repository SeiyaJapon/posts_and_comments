<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetCommentById;

use App\ShareContext\Application\Query\QueryResultInterface;

class GetCommentByIdQueryResult implements QueryResultInterface
{
    private array $comment;

    public function __construct(array $comment)
    {
        $this->comment = $comment;
    }

    public function result(): array
    {
        return $this->comment;
    }
}