<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Http\Post;

use App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQuery;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPostByIdController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $post = $this->queryBus->ask(new GetPostByIdQuery($id));

        return response()->json($post->result());
    }
}