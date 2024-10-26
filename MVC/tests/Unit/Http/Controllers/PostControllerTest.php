<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\PostController;
use App\Models\Post\Post;
use App\Usecases\Post\DeletePostUsecase;
use App\Usecases\Post\GetPostByIdUsecase;
use App\Usecases\Post\GetPostsUsecase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tests\TestCase;
use Mockery;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    private $getPostsUsecase;
    private $getPostByIdUsecase;
    private $deletePostUsecase;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getPostsUsecase = Mockery::mock(GetPostsUsecase::class);
        $this->getPostByIdUsecase = Mockery::mock(GetPostByIdUsecase::class);
        $this->deletePostUsecase = Mockery::mock(DeletePostUsecase::class);

        $this->controller = new PostController(
            $this->getPostsUsecase,
            $this->getPostByIdUsecase,
            $this->deletePostUsecase
        );
    }

    public function testIndex(): void
    {
        $request = Request::create('/posts', 'GET', [
            'page' => 1,
            'limit' => 10,
            'sort' => 'id',
            'direction' => 'asc'
        ]);

        $posts = [
            'result' => [new Post(), new Post()],
            'count' => 2
        ];

        $this->getPostsUsecase
            ->shouldReceive('execute')
            ->once()
            ->with([], 1, 10, 'id', 'asc')
            ->andReturn($posts);

        $response = $this->controller->index($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShow(): void
    {
        $postId = 1;
        $post = new Post();
        $post->id = $postId;

        $this->getPostByIdUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($postId)
            ->andReturn($post);

        $response = $this->controller->show($postId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShowNotFound(): void
    {
        $postId = 999;

        $this->getPostByIdUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($postId)
            ->andReturn(null);

        $response = $this->controller->show($postId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['error' => 'Post not found'], $response->getData(true));
    }

    public function testDestroy(): void
    {
        $postId = 1;

        $this->deletePostUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($postId)
            ->andReturn(true);

        $response = $this->controller->destroy($postId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['success' => true], $response->getData(true));
    }

    public function testDestroyNotFound(): void
    {
        $postId = 999;

        $this->deletePostUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($postId)
            ->andReturn(false);

        $response = $this->controller->destroy($postId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['error' => 'Post not found or could not be deleted'], $response->getData(true));
    }
}