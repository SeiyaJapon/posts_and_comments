<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\GetPostById;

use App\ShareContext\Application\Query\QueryInterface;

class GetPostByIdQuery implements QueryInterface
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}