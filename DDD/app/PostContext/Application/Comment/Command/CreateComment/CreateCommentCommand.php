<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Command\CreateComment;

use App\ShareContext\Application\Command\CommandInterface;

class CreateCommentCommand implements CommandInterface
{
    private string $id;
    private string $content;
    private string $postId;
    private string $abbreviation;

    public function __construct(string $id, string $content, string $postId, string $abbreviation)
    {
        $this->id = $id;
        $this->content = $content;
        $this->postId = $postId;
        $this->abbreviation = $abbreviation;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }
}