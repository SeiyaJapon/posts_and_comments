<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Post\Http;

use App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQuery;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetPostByIdController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        try {
            $post = $this->queryBus->ask(new GetPostByIdQuery($id));

            return response()->json(['result' => $post->result(), 'count' => 1]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}