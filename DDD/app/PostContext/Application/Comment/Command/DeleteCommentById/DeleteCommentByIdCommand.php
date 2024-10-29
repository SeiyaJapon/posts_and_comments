<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Command\DeleteCommentById;

use App\PostContext\Application\Comment\Query\DeleteCommentById\QueryInterface;
use App\ShareContext\Application\Command\CommandInterface;

class DeleteCommentByIdCommand implements CommandInterface
{
    private string $commentId;

    public function __construct(string $commentId)
    {
        $this->commentId = $commentId;
    }

    public function getCommentId(): string
    {
        return $this->commentId;
    }
}