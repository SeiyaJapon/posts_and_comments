<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Command\CreateComment;

use App\PostContext\Domain\Comment\CommentId;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;
use App\PostContext\Domain\Comment\Content;
use App\PostContext\Domain\Post\PostId;

class CreateCommentCommandHandler
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(CreateCommentCommand $command): void
    {
        $this->commentRepository->create(
            new CommentId($command->getId()),
            new Content($command->getContent()),
            new PostId($command->getPostId()),
            $command->getAbbreviation()
        );
    }
}