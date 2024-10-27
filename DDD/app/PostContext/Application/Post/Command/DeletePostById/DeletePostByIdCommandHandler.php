<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Command\DeletePostById;

use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;

class DeletePostByIdCommandHandler
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(DeletePostByIdCommand $query): void
    {
        $this->postRepository->deletePost(new PostId($query->postId()));
    }
}