<?php

declare (strict_types=1);

namespace App\Usecases\Post;

use App\Models\Post\Post;
use App\Repositories\PostRepository;

class GetPostByIdUsecase
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $id): ?Post
    {
        return $this->postRepository->getPostById($id);
    }
}