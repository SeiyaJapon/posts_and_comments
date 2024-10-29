<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Infrastructure\Post\Http;

use App\PostContext\Infrastructure\Post\Http\GetPostsController;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class GetPostsControllerTest extends TestCase
{
    private $queryBus;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = $this->createMock(QueryBusInterface::class);
        $this->queryBus->method('ask')->willReturn(new class {
            public function result()
            {
                return ['data' => 'test'];
            }
        });

        $this->controller = new GetPostsController($this->queryBus);
    }

    public function testInvokeWithDefaultParameters()
    {
        $request = Request::create('/posts', 'GET');

        $response = ($this->controller)($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($response->getStatusCode(), JsonResponse::HTTP_OK);
    }

    public function testInvokeWithAllParameters()
    {
        $request = Request::create('/posts', 'GET', [
            'page' => 1,
            'limit' => 10,
            'sort' => 'id',
            'direction' => 'asc',
            'with' => 'comments',
            'comment' => 'test comment'
        ]);

        $response = ($this->controller)($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['data' => 'test'], $response->getData(true));
    }

    public function testInvokeWithMissingOptionalParameters()
    {
        $request = Request::create('/posts', 'GET', [
            'page' => 1,
            'limit' => 10,
            'sort' => 'id',
            'direction' => 'asc'
        ]);

        $response = ($this->controller)($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['data' => 'test'], $response->getData(true));
    }

    public function testInvokeWithDifferentSortDirection()
    {
        $request = Request::create('/posts', 'GET', [
            'sort' => 'title',
            'direction' => 'desc'
        ]);

        $response = ($this->controller)($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['data' => 'test'], $response->getData(true));
    }

    public function testInvokeWithFilters()
    {
        $request = Request::create('/posts', 'GET', [
            'author' => 'John Doe',
            'category' => 'Tech'
        ]);

        $response = ($this->controller)($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['data' => 'test'], $response->getData(true));
    }
}