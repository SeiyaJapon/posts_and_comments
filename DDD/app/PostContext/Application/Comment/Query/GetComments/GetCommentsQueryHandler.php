<?php

declare (strict_types=1);

namespace App\PostContext\Application\Comment\Query\GetComments;

use App\PostContext\Domain\Comment\CommentRepositoryInterface;

class GetCommentsQueryHandler
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(GetCommentsQuery $query): GetCommentsQueryResult
    {
        return new GetCommentsQueryResult(
            $this->commentRepository->getComments(
                $query->getFilters(),
                $query->getPage(),
                $query->getLimit(),
                $query->getSort(),
                $query->getDirection(),
                $query->getWith()
            )
        );
    }
}