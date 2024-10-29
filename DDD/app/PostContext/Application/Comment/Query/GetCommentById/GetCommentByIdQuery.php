<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetCommentById;

use App\ShareContext\Application\Query\QueryInterface;

class GetCommentByIdQuery implements QueryInterface
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