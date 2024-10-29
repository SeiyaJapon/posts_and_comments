<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetCommentByAbbreviation;

use App\ShareContext\Application\Query\QueryResultInterface;

class GetCommentByAbbreviationQueryResult implements QueryResultInterface
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