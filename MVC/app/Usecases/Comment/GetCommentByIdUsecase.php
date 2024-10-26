<?php

declare (strict_types=1);

namespace App\Usecases\Comment;

use App\Models\Comment\Comment;
use App\Repositories\CommentRepository;

class GetCommentByIdUsecase
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function execute(int $id, $with = []): ?Comment
    {
        if (!is_array($with)) {
            $with = explode(',', $with);
        }

        return $this->commentRepository->getCommentById($id, $with);
    }
}