<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Command\DeletePostById;

use App\ShareContext\Application\Command\CommandInterface;

class DeletePostByIdCommand implements CommandInterface
{
    private string $postId;

    public function __construct(string $postId)
    {
        $this->postId = $postId;
    }

    public function postId(): string
    {
        return $this->postId;
    }
}