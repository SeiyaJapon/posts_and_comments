<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\GetPostById;

use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;

class GetPostByIdQueryHandler
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(GetPostByIdQuery $query): GetPostByIdQueryResult
    {
        $post = $this->postRepository->getPostById(
            new PostId($query->id())
        );

        return new GetPostByIdQueryResult($post->toArray());
    }
}