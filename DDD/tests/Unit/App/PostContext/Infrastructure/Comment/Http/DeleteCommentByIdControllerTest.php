<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Application\Comment\Command\DeleteCommentById\DeleteCommentByIdCommand;
use App\PostContext\Infrastructure\Comment\Http\DeleteCommentByIdController;
use App\ShareContext\Infrastructure\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;

class DeleteCommentByIdControllerTest extends TestCase
{
    private $commandBusMock;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBusMock = $this->createMock(CommandBusInterface::class);
        $this->controller = new DeleteCommentByIdController($this->commandBusMock);
    }

    public function test_it_deletes_a_comment_successfully()
    {
        $commentId = 'valid-comment-id';

        $this->commandBusMock->expects($this->once())
            ->method('handle')
            ->with($this->equalTo(new DeleteCommentByIdCommand($commentId)));

        $response = $this->controller->__invoke($commentId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertTrue($response->getData(true));
    }
}