<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQuery;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetCommentByIdController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $result = $this->queryBus->ask(
            new GetCommentByIdQuery($id, $request->get('with'))
        );

        return new JsonResponse(
            ['result' => $result->result(), 'count' => 1]
        );
    }
}