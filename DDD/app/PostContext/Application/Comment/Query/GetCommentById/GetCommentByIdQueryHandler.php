<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetCommentById;

use App\PostContext\Domain\Comment\CommentId;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;

class GetCommentByIdQueryHandler
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(GetCommentByIdQuery $query): GetCommentByIdQueryResult
    {
        $comment = $this->commentRepository->getCommentById(new CommentId($query->getId()), $query->getWith());

        return new GetCommentByIdQueryResult($comment->toArray());
    }
}