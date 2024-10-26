<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CommentController;
use App\Models\Comment\Comment;
use App\Usecases\Comment\CreateCommentUsecase;
use App\Usecases\Comment\DeleteCommentUsecase;
use App\Usecases\Comment\GetCommentByIdUsecase;
use App\Usecases\Comment\GetCommentsUsecase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Mockery;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private $createCommentUsecase;
    private $deleteCommentUsecase;
    private $getCommentByIdUsecase;
    private $getCommentsUsecase;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createCommentUsecase = Mockery::mock(CreateCommentUsecase::class);
        $this->deleteCommentUsecase = Mockery::mock(DeleteCommentUsecase::class);
        $this->getCommentByIdUsecase = Mockery::mock(GetCommentByIdUsecase::class);
        $this->getCommentsUsecase = Mockery::mock(GetCommentsUsecase::class);

        $this->controller = new CommentController(
            $this->createCommentUsecase,
            $this->deleteCommentUsecase,
            $this->getCommentByIdUsecase,
            $this->getCommentsUsecase
        );
    }

    public function testIndex(): void
    {
        $filters = [];
        $page = 1;
        $limit = 10;
        $sort = 'id';
        $direction = 'asc';
        $with = [];
        $commentsData = ['result' => [], 'count' => 0];

        $this->getCommentsUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($filters, $page, $limit, $sort, $direction, $with)
            ->andReturn($commentsData);

        $request = Request::create('/comments', 'GET');

        $response = $this->controller->index($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['result' => [], 'count' => 0], $response->getData(true));
    }

    public function testShowCommentExists(): void
    {
        $id = 1;
        $commentData = ['id' => $id, 'content' => 'Test content'];

        $this->getCommentByIdUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($id, '')
            ->andReturn(new Comment());

        $request = Request::create('/comments/1', 'GET');

        $response = $this->controller->show($id, $request);
        $data = json_decode($response->content(), true);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function testShowCommentNotFound(): void
    {
        $id = 1;

        $this->getCommentByIdUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($id, '')
            ->andReturn(null);

        $request = Request::create('/comments/1', 'GET');
        $response = $this->controller->show($id, $request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['error' => 'Comment not found'], $response->getData(true));
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDestroyCommentExists(): void
    {
        $id = 1;

        $this->deleteCommentUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($id)
            ->andReturn(true);

        $response = $this->controller->destroy($id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['success' => true], $response->getData(true));
    }

    public function testDestroyCommentNotFound(): void
    {
        $id = 1;

        $this->deleteCommentUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($id)
            ->andReturn(false);

        $response = $this->controller->destroy($id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['error' => 'Comment not found or could not be deleted'], $response->getData(true));
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testStore(): void
    {
        $data = [
            'post_id' => 1,
            'content' => 'Test content',
            'abbreviation' => 'TC'
        ];

        $createdComment = new Comment($data);

        $this->createCommentUsecase
            ->shouldReceive('execute')
            ->once()
            ->with($data)
            ->andReturn($createdComment);

        $request = Request::create('/comments', 'POST', $data);

        $response = $this->controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($createdComment, $response->getData(true));
        $this->assertEquals(201, $response->getStatusCode());
    }
}
