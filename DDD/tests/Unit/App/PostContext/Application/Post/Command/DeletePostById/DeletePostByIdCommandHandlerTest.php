<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Application\Post\Command\DeletePostById;

use App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommand;
use App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommandHandler;
use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeletePostByIdCommandHandlerTest extends TestCase
{
    private $postRepositoryMock;
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepositoryMock = $this->createMock(PostRepositoryInterface::class);
        $this->handler = new DeletePostByIdCommandHandler($this->postRepositoryMock);
    }

    public function test_handle_deletes_post_successfully()
    {
        $postId = Uuid::uuid4()->toString();
        $command = new DeletePostByIdCommand($postId);

        $this->postRepositoryMock->expects($this->once())
            ->method('deletePost')
            ->with($this->equalTo(new PostId($postId)));

        $this->handler->handle($command);
    }
}