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
    private ?string $with;

    public function __construct(
        array $filters = [],
        int $page = 1,
        int $limit = 10,
        string $sort = 'id',
        string $direction = 'asc',
        ?string $commentFilter = null,
        ?string $with = null
    ) {
        $this->filters = $filters;
        $this->page = $page;
        $this->limit = $limit;
        $this->sort = $sort;
        $this->direction = $direction;
        $this->commentFilter = $commentFilter;
        $this->with = $with;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getSort(): string
    {
        return $this->sort;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getCommentFilter(): ?string
    {
        return $this->commentFilter;
    }

    public function getWith(): ?string
    {
        return $this->with;
    }
}