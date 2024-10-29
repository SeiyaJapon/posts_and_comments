<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Application\Comment\Query\GetCommentById;

use App\Models\Comment\Comment;
use App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQuery;
use App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQueryHandler;
use App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQueryResult;

use App\PostContext\Domain\Comment\CommentId;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;
use App\PostContext\Domain\Comment\Content;
use App\PostContext\Domain\Post\PostId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetCommentByIdQueryHandlerTest extends TestCase
{
    private $commentRepositoryMock;
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepositoryInterface::class);
        $this->handler = new GetCommentByIdQueryHandler($this->commentRepositoryMock);
    }

    public function test_handle_returns_comment_successfully()
    {
        $commentId = Uuid::uuid4()->toString();
        $postId = Uuid::uuid4()->toString();
        $with = 'comments';
        $query = new GetCommentByIdQuery($commentId, $with);
        $comment = new Comment([$commentId, $postId, 'Test Comment', 'asdadxczxczx', new \DateTimeImmutable()]);

        $this->commentRepositoryMock->expects($this->once())
            ->method('getCommentById')
            ->with($this->equalTo(new CommentId($commentId)), $this->equalTo($with))
            ->willReturn($comment);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetCommentByIdQueryResult::class, $result);
        $this->assertIsArray($result->result());
    }
}