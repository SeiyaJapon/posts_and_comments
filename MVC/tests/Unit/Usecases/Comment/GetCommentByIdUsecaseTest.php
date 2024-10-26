<?php

declare (strict_types=1);

namespace Tests\Unit\Usecases\Comment;

use PHPUnit\Framework\TestCase;
use App\Usecases\Comment\GetCommentByIdUsecase;
use App\Repositories\CommentRepository;
use App\Models\Comment\Comment;

class GetCommentByIdUsecaseTest extends TestCase
{
    private $commentRepositoryMock;
    private $getCommentByIdUsecase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepository::class);

        $this->getCommentByIdUsecase = new GetCommentByIdUsecase($this->commentRepositoryMock);
    }

    public function testExecuteSuccess()
    {
        $commentId = 1;
        $comment = new Comment();
        $comment->id = $commentId;
        $comment->content = 'This is a comment';

        $this->commentRepositoryMock->expects($this->once())
            ->method('getCommentById')
            ->with($this->equalTo($commentId), $this->equalTo([]))
            ->willReturn($comment);

        $result = $this->getCommentByIdUsecase->execute($commentId);

        $this->assertInstanceOf(Comment::class, $result);
        $this->assertEquals($commentId, $result->id);
        $this->assertEquals('This is a comment', $result->content);
    }

    public function testExecuteWithRelations()
    {
        $commentId = 1;
        $with = ['post', 'author'];
        $comment = new Comment();
        $comment->id = $commentId;
        $comment->content = 'This is a comment';

        $this->commentRepositoryMock->expects($this->once())
            ->method('getCommentById')
            ->with($this->equalTo($commentId), $this->equalTo($with))
            ->willReturn($comment);

        $result = $this->getCommentByIdUsecase->execute($commentId, $with);

        $this->assertInstanceOf(Comment::class, $result);
        $this->assertEquals($commentId, $result->id);
        $this->assertEquals('This is a comment', $result->content);
    }

    public function testExecuteCommentNotFound()
    {
        $commentId = 999;

        $this->commentRepositoryMock->expects($this->once())
            ->method('getCommentById')
            ->with($this->equalTo($commentId), $this->equalTo([]))
            ->willReturn(null);

        $result = $this->getCommentByIdUsecase->execute($commentId);

        $this->assertNull($result);
    }
}