<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Http\Post;

use App\PostContext\Application\Post\Query\DeletePostById\DeletePostByIdQuery;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;

class DeletePostByIdController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(string $id): JsonResponse
    {
        $success = $this->queryBus->ask(new DeletePostByIdQuery($id));

        return response()->json($success->result());
    }
}