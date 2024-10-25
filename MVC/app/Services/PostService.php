<?php

declare (strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPosts(array $filters = [], int $page = 1, int $limit = 10, string $sort = 'id', string $direction = 'asc'): array
    {
        $commentFilter = $filters['comment'] ?? null;
        unset($filters['comment']);

        return $this->postRepository->getPosts($filters, $page, $limit, $sort, $direction, $commentFilter);
    }

    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->getPostById($id);
    }

    public function deletePost(int $id): bool
    {
        return $this->postRepository->deletePost($id);
    }
}