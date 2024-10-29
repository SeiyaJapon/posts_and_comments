<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Application\Comment\Query\GetComments\GetCommentsQuery;
use App\PostContext\Application\Comment\Query\GetComments\GetCommentsQueryResult;
use App\PostContext\Infrastructure\Comment\Http\GetCommentsController;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class GetCommentsControllerTest extends TestCase
{
    private $queryBusMock;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBusMock = $this->createMock(QueryBusInterface::class);
        $this->controller = new GetCommentsController($this->queryBusMock);
    }

    public function test_it_returns_comments_successfully()
    {
        $filters = ['post_id' => 1];
        $page = 1;
        $limit = 10;
        $sort = 'id';
        $direction = 'asc';
        $with = 'author';
        $request = Request::create('/comments', 'GET', array_merge($filters, [
            'page' => $page,
            'limit' => $limit,
            'sort' => $sort,
            'direction' => $direction,
            'with' => $with,
        ]));
        $expectedResult = new GetCommentsQueryResult([['id' => 1, 'content' => 'Test comment']]);

        $this->queryBusMock->expects($this->once())
            ->method('ask')
            ->with($this->equalTo(new GetCommentsQuery($filters, $page, $limit, $sort, $direction, $with)))
            ->willReturn($expectedResult);

        $response = $this->controller->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            json_decode(json_encode($expectedResult->result()), true),
            json_decode($response->getContent(), true)
        );
    }
}