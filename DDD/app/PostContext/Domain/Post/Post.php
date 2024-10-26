<?php

declare (strict_types=1);

namespace App\PostContext\Domain\Post;

use DateTimeImmutable;

class Post
{
    private PostId $id;
    private Topic $topic;
    private DateTimeImmutable $createdAt;

    public function __construct(PostId $id, Topic $topic, DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->topic = $topic;
        $this->createdAt = $createdAt;
    }

    public function id(): PostId
    {
        return $this->id;
    }

    public function topic(): Topic
    {
        return $this->topic;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
