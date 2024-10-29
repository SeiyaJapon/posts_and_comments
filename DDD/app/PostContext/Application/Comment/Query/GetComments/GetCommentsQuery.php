<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetComments;

use App\ShareContext\Application\Query\QueryInterface;

class GetCommentsQuery implements QueryInterface
{
    public array $filters;
    public int $page;
    public int $limit;
    public string $sort;
    public string $direction;
    public array $with;

    public function __construct(
        array $filters = [],
        int $page = 1,
        int $limit = 10,
        string $sort = 'id',
        string $direction = 'asc',
        array $with = []
    ) {
        $this->filters = $filters;
        $this->page = $page;
        $this->limit = $limit;
        $this->sort = $sort;
        $this->direction = $direction;
        $this->with = $with;
    }
}