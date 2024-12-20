<?php

declare (strict_types=1);

namespace App\Models\Post;

interface PostRepositoryInterface
{
    public function getPosts(array $filters = [], int $page = 1, int $limit = 10, string $sort = 'id', string $direction = 'asc', ?string $commentFilter = null, ?string $with = null): array;
    public function getPostById(int $id): ?Post;
    public function deletePost(int $id): bool;
    public function existsById(int $id): bool;
}