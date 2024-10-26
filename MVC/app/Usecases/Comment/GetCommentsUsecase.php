<?php

declare (strict_types=1);

namespace App\Usecases\Comment;

use App\Repositories\CommentRepository;

class GetCommentsUsecase
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function execute(array $filters, int $page, int $limit, string $sort, string $direction, array $with): array
    {
        return $this->commentRepository->getPaginated($filters, $page, $limit, $sort, $direction, $with);
    }
}