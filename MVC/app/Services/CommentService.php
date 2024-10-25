<?php

declare (strict_types=1);

namespace App\Services;

use App\Exceptions\PostNotFoundException;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Exceptions\CommentNotFoundException;
use App\Repositories\PostRepository;

class CommentService
{
    protected $commentRepository;
    private PostRepository $postRepository;

    public function __construct(CommentRepository $commentRepository, PostRepository $postRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    public function getComments(array $filters, int $page, int $limit, string $sort, string $direction): array
    {
        return $this->commentRepository->getPaginated($filters, $page, $limit, $sort, $direction);
    }

    public function getCommentById(int $id, $with = []): ?Comment
    {
        try {
            if (!is_array($with)) {
                $with = explode(',', $with);
            }
            return $this->commentRepository->getCommentById($id, $with);
        } catch (\Exception $e) {
            return $this->commentRepository->getCommentById($id);
        }
    }


    public function deleteComment(int $id): bool
    {
        $deleted = $this->commentRepository->deleteById($id);

        if (!$deleted) {
            throw new CommentNotFoundException();
        }

        return true;
    }

    public function createComment(array $data): Comment
    {
        try {
            if (!$this->postRepository->existsById($data['post_id'])) {
                throw new PostNotFoundException($data['post_id']);
            }

            return $this->commentRepository->create($data);
        } catch (PostNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception('An error occurred while creating the comment');
        }
    }
}