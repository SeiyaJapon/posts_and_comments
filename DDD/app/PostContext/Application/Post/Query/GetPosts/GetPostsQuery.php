<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\GetPosts;

use App\ShareContext\Application\Query\QueryInterface;

class GetPostsQuery implements QueryInterface
{
    public array $filters;
    public int $page;
    public int $limit;
    public string $sort;
    public string $direction;
    public ?string $commentFilter;

    public function __construct(
        array $filters = [],
        int $page = 1,
        int $limit = 10,
        string $sort = 'id',
        string $direction = 'asc',
        ?string $commentFilter = null
    ) {
        $this->filters = $filters;
        $this->page = $page;
        $this->limit = $limit;
        $this->sort = $sort;
        $this->direction = $direction;
        $this->commentFilter = $commentFilter;
    }
}