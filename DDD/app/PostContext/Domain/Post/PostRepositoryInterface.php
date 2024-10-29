<?php

declare (strict_types=1);

namespace App\PostContext\Domain\Post;

use App\Models\Post\Post;

interface PostRepositoryInterface
{
    public function getPosts(array $filters = [], int $page = 1, int $limit = 10, string $sort = 'id', string $direction = 'asc', ?string $commentFilter = null, ?string $with = null): array;
    public function getPostById(PostId $id): ?Post;
    public function deletePost(PostId $id): bool;
    public function existsById(PostId $id): bool;
}