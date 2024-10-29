<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQuery;
use App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQueryResult;
use App\PostContext\Infrastructure\Comment\Http\GetCommentByIdController;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class GetCommentByIdControllerTest extends TestCase
{
    private $queryBusMock;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBusMock = $this->createMock(QueryBusInterface::class);
        $this->controller = new GetCommentByIdController($this->queryBusMock);
    }

    public function test_it_returns_comment_successfully()
    {
        $commentId = 'valid-comment-id';
        $request = Request::create('/comments/' . $commentId, 'GET', ['with' => 'author']);
        $expectedResult = new GetCommentByIdQueryResult(['foo' => 'bar']);

        $this->queryBusMock->expects($this->once())
            ->method('ask')
            ->with($this->equalTo(new GetCommentByIdQuery($commentId, 'author')))
            ->willReturn($expectedResult);

        $response = $this->controller->__invoke($commentId, $request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            ['result' => $expectedResult->result(), 'count' => 1],
            json_decode($response->getContent(), true)
        );
    }
}