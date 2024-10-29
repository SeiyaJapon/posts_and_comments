<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Infrastructure\Post\Http;

use App\PostContext\Infrastructure\Post\Http\DeletePostByIdController;
use App\PostContext\Infrastructure\Post\Service\DeletePostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;

class DeletePostByIdControllerTest extends TestCase
{
    private DeletePostService $deletePostServiceMock;
    private DeletePostByIdController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deletePostServiceMock = $this->createMock(DeletePostService::class);
        $this->controller = new DeletePostByIdController($this->deletePostServiceMock);
    }

    public function test_it_deletes_a_post_successfully()
    {
        $postId = 'valid-post-id';

        $this->deletePostServiceMock->expects($this->once())
            ->method('execute')
            ->with($postId);

        $response = $this->controller->__invoke($postId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    public function test_it_returns_not_found_when_post_does_not_exist()
    {
        $postId = 'non-existing-post-id';

        $this->deletePostServiceMock->expects($this->once())
            ->method('execute')
            ->with($postId);

        $response = $this->controller->__invoke($postId);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}