<?php

declare (strict_types=1);

namespace App\PostContext\Application\Post\Query\GetPosts;

use App\PostContext\Domain\Post\PostRepositoryInterface;

class GetPostsQueryHandler
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(GetPostsQuery $query): GetPostsQueryResult
    {
        return new GetPostsQueryResult(
            $this->postRepository->getPosts(
                $query->getFilters(),
                $query->getPage(),
                $query->getLimit(),
                $query->getSort(),
                $query->getDirection(),
                $query->getCommentFilter(),
                $query->getWith()
            )
        );
    }
}