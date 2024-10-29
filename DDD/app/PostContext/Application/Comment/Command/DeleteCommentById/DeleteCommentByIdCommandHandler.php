<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Command\DeleteCommentById;

use App\PostContext\Domain\Comment\CommentId;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;

class DeleteCommentByIdCommandHandler
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(DeleteCommentByIdCommand $command): void
    {
        $this->commentRepository->deleteById(new CommentId($command->getCommentId()));
    }
}