<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\DeletePostById;

use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;

class DeletePostByIdQueryHandler
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(DeletePostByIdQuery $query): DeletePostByIdQueryResult
    {
        return new DeletePostByIdQueryResult(
            $this->postRepository->deletePost(new PostId($query->postId()))
        );
    }
}