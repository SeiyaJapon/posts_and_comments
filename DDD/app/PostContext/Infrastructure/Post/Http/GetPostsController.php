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
        $filters = $request->except(['page', 'limit', 'sort', 'direction', 'with']);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
        $with = $request->get('with', null);

        $commentFilter = $filters['comment'] ?? null;
        unset($filters['comment']);

        $result = $this->queryBus->ask(new GetPostsQuery($filters, intval($page), intval($limit), $sort, $direction, $commentFilter, $with));

        return new JsonResponse($result->result());
    }
}