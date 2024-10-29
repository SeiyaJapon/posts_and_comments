<?php

declare (strict_types=1);

namespace App\Usecases\Post;

use App\Repositories\PostRepository;

class GetPostsUsecase
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(array $filters = [], int $page = 1, int $limit = 10, string $sort = 'id', string $direction = 'asc', ?string $with = null): array
    {
        $commentFilter = $filters['comment'] ?? null;
        unset($filters['comment']);

        return $this->postRepository->getPosts($filters, $page, $limit, $sort, $direction, $commentFilter, $with);
    }
}