<?php

declare (strict_types=1);

namespace App\Usecases\Post;

use App\Repositories\PostRepository;

class DeletePostUsecase
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $id): bool
    {
        return $this->postRepository->deletePost($id);
    }
}