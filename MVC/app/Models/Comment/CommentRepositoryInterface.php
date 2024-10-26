<?php

declare (strict_types=1);

namespace App\Models\Comment;

interface CommentRepositoryInterface
{
    public function getPaginated(array $filters, int $page, int $limit, string $sort, string $direction, array $with): array;
    public function getCommentById(int $id, array $with = []): ?Comment;
    public function create(array $data): Comment;
    public function deleteById(int $id): bool;
}