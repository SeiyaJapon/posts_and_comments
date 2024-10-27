<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Post\Http;

use App\PostContext\Application\Post\Query\GetPosts\GetPostsQuery;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPostsController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $filters = $request->except(['page', 'limit', 'sort', 'direction']);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
        $commentFilter = $request->get('comment', null);

        $result = $this->queryBus->ask(new GetPostsQuery($filters, intval($page), intval($limit), $sort, $direction, $commentFilter));

        return response()->json($result->result());
    }
}