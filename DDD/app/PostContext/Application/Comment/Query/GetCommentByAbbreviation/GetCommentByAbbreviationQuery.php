<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetCommentByAbbreviation;

use App\ShareContext\Application\Query\QueryInterface;

class GetCommentByAbbreviationQuery implements QueryInterface
{
    public string $abbreviation;

    public function __construct(string $abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }
}