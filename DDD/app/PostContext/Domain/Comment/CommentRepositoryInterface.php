<?php

declare (strict_types=1);

namespace App\PostContext\Domain\Comment;

use App\Models\Comment\Comment;
use App\PostContext\Domain\Post\PostId;

interface CommentRepositoryInterface
{
    public function getComments(array $filters, int $page, int $limit, string $sort, string $direction, ?string $with): array;
    public function getCommentById(CommentId $id, ?string $with = null): ?Comment;
    public function create(CommentId $id, Content $content, PostId $postId, string $abbreviation): Comment;
    public function deleteById(CommentId $id): bool;
    public function existsByAbbreviation(string $value): bool;
}