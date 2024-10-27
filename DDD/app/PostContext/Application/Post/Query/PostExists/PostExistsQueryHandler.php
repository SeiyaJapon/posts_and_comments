<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\PostExists;

use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;

class PostExistsQueryHandler
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(PostExistsQuery $query): PostExistsQueryResult
    {
        $post = $this->postRepository->existsById(new PostId($query->postId()));

        return new PostExistsQueryResult($post !== null);
    }
}