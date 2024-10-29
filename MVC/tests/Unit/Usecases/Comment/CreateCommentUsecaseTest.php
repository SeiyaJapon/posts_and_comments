<?php

declare (strict_types=1);

namespace Tests\Unit\Usecases\Comment;

use App\Exceptions\AlredyAbbreviationExistsException;
use PHPUnit\Framework\TestCase;
use App\Usecases\Comment\CreateCommentUsecase;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Models\Comment\Comment;
use App\Exceptions\PostNotFoundException;

class CreateCommentUsecaseTest extends TestCase
{
    private $commentRepositoryMock;
    private $postRepositoryMock;
    private $createCommentUsecase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepository::class);
        $this->postRepositoryMock = $this->createMock(PostRepository::class);

        $this->createCommentUsecase = new CreateCommentUsecase($this->commentRepositoryMock, $this->postRepositoryMock);
    }

    public function testExecuteSuccess()
    {
        $data = [
            'post_id' => 1,
            'content' => 'This is a comment',
            'abbreviation' => 'abc'
        ];
        $comment = new Comment();
        $comment->post_id = $data['post_id'];
        $comment->content = $data['content'];

        $this->postRepositoryMock
            ->expects($this->once())
            ->method('existsById')
            ->with($this->equalTo($data['post_id']))
            ->willReturn(true);

        $this->commentRepositoryMock
            ->expects($this->once())
            ->method('existsByAbbreviation')
            ->with($this->equalTo($data['abbreviation']))
            ->willReturn(false);

        $this->commentRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($this->equalTo($data))
            ->willReturn($comment);

        $result = $this->createCommentUsecase->execute($data);

        $this->assertInstanceOf(Comment::class, $result);
        $this->assertEquals($data['post_id'], $result->post_id);
        $this->assertEquals($data['content'], $result->content);
    }

    public function testExecutePostNotFound()
    {
        $data = [
            'post_id' => 1,
            'content' => 'This is a comment',
            'abbreviation' => 'abc'
        ];

        $this->postRepositoryMock
            ->expects($this->once())
            ->method('existsById')
            ->with($this->equalTo($data['post_id']))
            ->willReturn(false);

        $this->expectException(PostNotFoundException::class);

        $this->createCommentUsecase->execute($data);
    }

    public function testExecuteAbbreviationExists()
    {
        $data = [
            'post_id' => 1,
            'content' => 'This is a comment',
            'abbreviation' => 'abc'
        ];

        $this->postRepositoryMock
            ->expects($this->once())
            ->method('existsById')
            ->with($this->equalTo($data['post_id']))
            ->willReturn(true);

        $this->commentRepositoryMock
            ->expects($this->once())
            ->method('existsByAbbreviation')
            ->with($this->equalTo($data['abbreviation']))
            ->willReturn(true);

        $this->expectException(AlredyAbbreviationExistsException::class);
        $this->expectExceptionMessage('The abbreviation is already in use');

        $this->createCommentUsecase->execute($data);
    }

    public function testExecuteCreateCommentException()
    {
        $data = [
            'post_id' => 1,
            'content' => 'This is a comment',
            'abbreviation' => 'abc'
        ];

        $this->postRepositoryMock
            ->expects($this->once())
            ->method('existsById')
            ->with($this->equalTo($data['post_id']))
            ->willReturn(true);

        $this->commentRepositoryMock
            ->expects($this->once())
            ->method('existsByAbbreviation')
            ->with($this->equalTo($data['abbreviation']))
            ->willReturn(false);

        $this->commentRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($this->equalTo($data))
            ->will($this->throwException(new \Exception('An error occurred while creating the comment')));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('An error occurred while creating the comment');

        $this->createCommentUsecase->execute($data);
    }
}