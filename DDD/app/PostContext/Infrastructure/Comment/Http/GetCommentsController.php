<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Application\Comment\Query\GetComments\GetCommentsQuery;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetCommentsController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $filters = $request->except(['page', 'limit', 'sort', 'direction', 'with']);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
        $with = $request->get('with', []);

        $result = $this->queryBus->ask(new GetCommentsQuery($filters, intval($page), intval($limit), $sort, $direction, $with));

        return response()->json($result->result());
    }
}