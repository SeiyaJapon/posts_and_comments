<?php

declare (strict_types=1);

namespace App\Usecases\Comment;

use App\Exceptions\CommentNotFoundException;
use App\Repositories\CommentRepository;

class DeleteCommentUsecase
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function execute(int $id): bool
    {
        $deleted = $this->commentRepository->deleteById($id);

        if (!$deleted) {
            throw new CommentNotFoundException();
        }

        return true;
    }
}