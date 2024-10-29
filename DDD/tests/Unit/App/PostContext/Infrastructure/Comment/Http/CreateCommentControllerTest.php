<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Infrastructure\Comment\Http\CreateCommentController;
use App\PostContext\Infrastructure\Comment\Service\CreateCommentService;
use App\PostContext\Infrastructure\Comment\Service\ValidateCreateDataService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\TestCase;

class CreateCommentControllerTest extends TestCase
{
    private $createCommentServiceMock;
    private $validateService;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createCommentServiceMock = $this->createMock(CreateCommentService::class);
        $this->validateService = $this->createMock(ValidateCreateDataService::class);

        $this->controller = new CreateCommentController(
            $this->createCommentServiceMock,
            $this->validateService
        );
    }

    public function test_it_creates_a_comment_successfully()
    {
        $data = [
            'post_id' => 'valid-post-id',
            'content' => 'Test comment content',
            'abbreviation' => 'TCC'
        ];
        $request = Request::create('/comments', 'POST', $data);

        $this->validateService->expects($this->once())
            ->method('validate')
            ->willReturn($data);

        $this->createCommentServiceMock->expects($this->once())
            ->method('createComment')
            ->with($data)
            ->willReturn(['success' => true]);

        $response = $this->controller->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
        $this->assertEquals(['success' => true], $response->getData(true));
    }

    public function test_it_returns_bad_request_on_invalid_data()
    {
        $request = Request::create('/comments', 'POST', [
            'post_id' => null,
            'content' => null,
            'abbreviation' => null
        ]);

        $this->validateService->expects($this->once())
            ->method('validate')
            ->with($request)
            ->willThrowException(new \Exception('The given data was invalid.'));

        $response = $this->controller->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->status());
        $this->assertEquals(['error' => 'The given data was invalid.'], $response->getData(true));
    }

    public function test_it_returns_bad_request_on_exception()
    {
        $data = [
            'post_id' => 'valid-post-id',
            'content' => 'Test comment content',
            'abbreviation' => 'TCC'
        ];
        $request = Request::create('/comments', 'POST', $data);

        $this->validateService->expects($this->once())
            ->method('validate')
            ->with($request)
            ->willReturn($data);

        $this->createCommentServiceMock->expects($this->once())
            ->method('createComment')
            ->will($this->throwException(new \Exception('Error creating comment')));

        $response = $this->controller->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->status());
        $this->assertEquals(['error' => 'Error creating comment'], $response->getData(true));
    }
}