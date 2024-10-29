<?php

declare (strict_types=1);

namespace App\Usecases\Comment;

use App\Exceptions\AlredyAbbreviationExistsException;
use App\Exceptions\PostNotFoundException;
use App\Models\Comment\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;

class CreateCommentUsecase
{
    private CommentRepository $commentRepository;
    private PostRepository $postRepository;

    public function __construct(CommentRepository $commentRepository, PostRepository $postRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    public function execute(array $data): Comment
    {
        if (!$this->postRepository->existsById($data['post_id'])) {
            throw new PostNotFoundException($data['post_id']);
        }

        if ($this->commentRepository->existsByAbbreviation($data['abbreviation'])) {
            throw new AlredyAbbreviationExistsException('The abbreviation is already in use');
        }

        try {
            return $this->commentRepository->create($data);
        } catch (\Exception $e) {
            throw new \Exception('An error occurred while creating the comment');
        }
    }
}