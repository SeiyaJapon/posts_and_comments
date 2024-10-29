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
    private string $abbreviation;
    private \DateTime $createdAt;

    public function __construct(CommentId $id, PostId $postId, Content $content, string $abbreviation, \DateTime $createdAt)
    {
        $this->id = $id;
        $this->postId = $postId;
        $this->content = $content;
        $this->abbreviation = $abbreviation;
        $this->createdAt = $createdAt;
    }

    public function getId(): CommentId
    {
        return $this->id;
    }

    public function getPostId(): PostId
    {
        return $this->postId;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
