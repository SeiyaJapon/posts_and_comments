<?php

declare (strict_types=1);

namespace App\PostContext\Domain\Comment;

use App\PostContext\Domain\Post\PostId;
use DateTimeImmutable;

class Comment
{
    private CommentId $id;
    private PostId $postId;
    private Content $content;
    private DateTimeImmutable $createdAt;

    public function __construct(CommentId $id, PostId $postId, Content $content, DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->postId = $postId;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    public function id(): CommentId
    {
        return $this->id;
    }

    public function postId(): PostId
    {
        return $this->postId;
    }

    public function content(): Content
    {
        return $this->content;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
