<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetCommentById;

use App\ShareContext\Application\Query\QueryInterface;

class GetCommentByIdQuery implements QueryInterface
{
    private string $id;
    private ?string $with;

    public function __construct(string $id, ?string $with = null)
    {
        $this->id = $id;
        $this->with = $with;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getWith(): ?string
    {
        return $this->with;
    }
}