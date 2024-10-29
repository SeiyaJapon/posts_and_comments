<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\GetPostById;

use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;
use Illuminate\Http\Response;

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
            new PostId($query->getId()),
            $query->getWith()
        );

        if (empty($post)) {
            throw new \Exception('Post not found', Response::HTTP_NOT_FOUND);
        }

        return new GetPostByIdQueryResult($post->toArray());
    }
}