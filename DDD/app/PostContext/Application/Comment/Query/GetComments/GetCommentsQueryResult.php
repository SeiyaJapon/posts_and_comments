<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetComments;

use App\ShareContext\Application\Query\QueryResultInterface;

class GetCommentsQueryResult implements QueryResultInterface
{
    private array $comments;

    public function __construct(array $comments)
    {
        $this->comments = $comments;
    }

    public function result(): array
    {
        return $this->comments;
    }
}