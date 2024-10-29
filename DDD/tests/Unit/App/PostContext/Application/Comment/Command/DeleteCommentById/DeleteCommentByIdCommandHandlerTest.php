<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Application\Comment\Command\DeleteCommentById;

use App\PostContext\Application\Comment\Command\DeleteCommentById\DeleteCommentByIdCommand;
use App\PostContext\Application\Comment\Command\DeleteCommentById\DeleteCommentByIdCommandHandler;
use App\PostContext\Domain\Comment\CommentId;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCommentByIdCommandHandlerTest extends TestCase
{
    private $commentRepositoryMock;
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepositoryInterface::class);
        $this->handler = new DeleteCommentByIdCommandHandler($this->commentRepositoryMock);
    }

    public function test_handle_deletes_comment_successfully()
    {
        $commentId = Uuid::uuid4()->toString();
        $command = new DeleteCommentByIdCommand($commentId);

        $this->commentRepositoryMock->expects($this->once())
            ->method('deleteById')
            ->with(new CommentId($commentId));

        $this->handler->handle($command);
    }
}