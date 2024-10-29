<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Application\Comment\Command\CreateComment;

use App\PostContext\Application\Comment\Command\CreateComment\CreateCommentCommand;
use App\PostContext\Application\Comment\Command\CreateComment\CreateCommentCommandHandler;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;
use App\PostContext\Domain\Comment\CommentId;
use App\PostContext\Domain\Comment\Content;
use App\PostContext\Domain\Post\PostId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateCommentCommandHandlerTest extends TestCase
{
    private $commentRepositoryMock;
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepositoryInterface::class);
        $this->handler = new CreateCommentCommandHandler($this->commentRepositoryMock);
    }

    public function test_handle_creates_comment_successfully()
    {
        $commentId = Uuid::uuid4()->toString();
        $content = 'Test Comment';
        $postId = Uuid::uuid4()->toString();
        $abbreviation = 'test-abbreviation';
        $command = new CreateCommentCommand($commentId, $content, $postId, $abbreviation);

        $this->commentRepositoryMock->expects($this->once())
            ->method('create')
            ->with(
                $this->equalTo(new CommentId($commentId)),
                $this->equalTo(new Content($content)),
                $this->equalTo(new PostId($postId)),
                $this->equalTo($abbreviation)
            );

        $this->handler->handle($command);
    }
}