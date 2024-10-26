<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\GetPostById;

use App\ShareContext\Application\Query\QueryResultInterface;

class GetPostByIdQueryResult implements QueryResultInterface
{
    private array $post;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    public function result(): array
    {
        return $this->post;
    }
}