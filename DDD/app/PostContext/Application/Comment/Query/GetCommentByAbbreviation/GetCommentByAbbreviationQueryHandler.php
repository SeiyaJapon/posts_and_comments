<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetCommentByAbbreviation;

use App\PostContext\Domain\Comment\CommentId;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;

class GetCommentByAbbreviationQueryHandler
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(GetCommentByAbbreviationQuery $query): GetCommentByAbbreviationQueryResult
    {
        return new GetCommentByAbbreviationQueryResult(
            $this->commentRepository->existsByAbbreviation($query->getAbbreviation())
        );
    }
}