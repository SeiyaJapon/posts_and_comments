<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Infrastructure\Post\Service;

use App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommand;
use App\PostContext\Application\Post\Query\PostExists\PostExistsQuery;
use App\PostContext\Infrastructure\Post\Service\DeletePostService;
use App\ShareContext\Infrastructure\CommandBus\CommandBusInterface;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;

class DeletePostServiceTest extends TestCase
{
    private $commandBusMock;
    private $queryBusMock;
    private $deletePostService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBusMock = $this->createMock(CommandBusInterface::class);
        $this->queryBusMock = $this->createMock(QueryBusInterface::class);

        $this->deletePostService = new DeletePostService($this->commandBusMock, $this->queryBusMock);
    }

    public function test_it_deletes_a_post_successfully()
    {
        $postId = 'valid-post-id';

        $this->commandBusMock->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(DeletePostByIdCommand::class));

        $this->deletePostService->execute($postId);
    }

    public function test_it_throws_exception_on_error()
    {
        $postId = 'valid-post-id';

        $this->commandBusMock->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(DeletePostByIdCommand::class))
            ->will($this->throwException(new \Exception('Error deleting post')));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error deleting post');

        $this->deletePostService->execute($postId);
    }
}