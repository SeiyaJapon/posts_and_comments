<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\PostExists;

use App\ShareContext\Application\Query\QueryInterface;

class PostExistsQuery implements QueryInterface
{
    private string $postId;

    public function __construct(string $postId)
    {
        $this->postId = $postId;
    }

    public function postId(): string
    {
        return $this->postId;
    }
}