<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Infrastructure\Post\Http;

use App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQuery;
use App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQueryResult;
use App\PostContext\Infrastructure\Post\Http\GetPostByIdController;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;

class GetPostByIdControllerTest extends TestCase
{
    private QueryBusInterface $queryBusMock;
    private GetPostByIdController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->queryBusMock = $this->createMock(QueryBusInterface::class);
        $this->controller = new GetPostByIdController($this->queryBusMock);
    }

    public function test_it_returns_a_post_successfully()
    {
        $postId = 'valid-post-id';
        $expectedResult = [
            'id' => $postId,
            'title' => 'Test Post Title',
            'content' => 'Test Post Content',
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString()
        ];

        $this->queryBusMock->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(GetPostByIdQuery::class))
            ->willReturn(new GetPostByIdQueryResult($expectedResult));

        $request = Request::create('/posts/' . $postId, 'GET');
        $response = $this->controller->__invoke($postId, $request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertEquals([
            'result' => $expectedResult,
            'count' => 1
        ], $response->getData(true));
    }

    public function test_it_returns_not_found_when_post_does_not_exist()
    {
        $postId = 'non-existing-post-id';

        $this->queryBusMock->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(GetPostByIdQuery::class))
            ->will($this->throwException(new \Exception('Post not found', Response::HTTP_NOT_FOUND)));

        $request = Request::create('/posts/' . $postId, 'GET');
        $response = $this->controller->__invoke($postId, $request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->status());
        $this->assertEquals([
            'error' => 'Post not found'
        ], $response->getData(true));
    }
}