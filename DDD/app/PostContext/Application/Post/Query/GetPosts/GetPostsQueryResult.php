<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\GetPosts;

use App\ShareContext\Application\Query\QueryResultInterface;

class GetPostsQueryResult implements QueryResultInterface
{
    private array $posts;

    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    public function result(): array
    {
        return $this->posts;
    }
}