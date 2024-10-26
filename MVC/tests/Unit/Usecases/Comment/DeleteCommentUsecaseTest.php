<?php

declare (strict_types=1);

namespace Tests\Unit\Usecases\Comment;

use PHPUnit\Framework\TestCase;
use App\Usecases\Comment\DeleteCommentUsecase;
use App\Repositories\CommentRepository;
use App\Exceptions\CommentNotFoundException;

class DeleteCommentUsecaseTest extends TestCase
{
    private $commentRepositoryMock;
    private $deleteCommentUsecase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepository::class);

        $this->deleteCommentUsecase = new DeleteCommentUsecase($this->commentRepositoryMock);
    }

    public function testExecuteSuccess()
    {
        $commentId = 1;

        $this->commentRepositoryMock->expects($this->once())
            ->method('deleteById')
            ->with($this->equalTo($commentId))
            ->willReturn(true);

        $result = $this->deleteCommentUsecase->execute($commentId);

        $this->assertTrue($result);
    }

    public function testExecuteCommentNotFound()
    {
        $commentId = 999;

        $this->commentRepositoryMock->expects($this->once())
            ->method('deleteById')
            ->with($this->equalTo($commentId))
            ->willReturn(false);

        $this->expectException(CommentNotFoundException::class);

        $this->deleteCommentUsecase->execute($commentId);
    }

    public function testExecuteDeleteFailure()
    {
        $commentId = 1;

        $this->commentRepositoryMock->expects($this->once())
            ->method('deleteById')
            ->with($this->equalTo($commentId))
            ->will($this->throwException(new \Exception('Failed to delete comment')));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to delete comment');

        $this->deleteCommentUsecase->execute($commentId);
    }
}