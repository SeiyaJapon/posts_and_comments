<?php

declare (strict_types=1);

namespace Tests\Unit\Usecases\Comment;

use PHPUnit\Framework\TestCase;
use App\Usecases\Comment\GetCommentsUsecase;
use App\Repositories\CommentRepository;
use App\Models\Comment\Comment;

class GetCommentsUsecaseTest extends TestCase
{
    private $commentRepositoryMock;
    private $getCommentsUsecase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepository::class);

        $this->getCommentsUsecase = new GetCommentsUsecase($this->commentRepositoryMock);
    }

    public function testExecuteSuccess()
    {
        $filters = ['post_id' => 1];
        $page = 1;
        $limit = 10;
        $sort = 'id';
        $direction = 'asc';
        $with = 'post';
        $comments = [new Comment(), new Comment()];

        $this->commentRepositoryMock->expects($this->once())
            ->method('getPaginated')
            ->with($this->equalTo($filters), $this->equalTo($page), $this->equalTo($limit), $this->equalTo($sort), $this->equalTo($direction), $this->equalTo($with))
            ->willReturn($comments);

        $result = $this->getCommentsUsecase->execute($filters, $page, $limit, $sort, $direction, $with);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Comment::class, $result[0]);
    }

    public function testExecuteWithEmptyFilters()
    {
        $filters = [];
        $page = 1;
        $limit = 10;
        $sort = 'id';
        $direction = 'asc';
        $with = null;
        $comments = [new Comment(), new Comment()];

        $this->commentRepositoryMock->expects($this->once())
            ->method('getPaginated')
            ->with($this->equalTo($filters), $this->equalTo($page), $this->equalTo($limit), $this->equalTo($sort), $this->equalTo($direction), $this->equalTo($with))
            ->willReturn($comments);

        $result = $this->getCommentsUsecase->execute($filters, $page, $limit, $sort, $direction, $with);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Comment::class, $result[0]);
    }

    public function testExecuteWithDifferentPagination()
    {
        $filters = ['post_id' => 1];
        $page = 2;
        $limit = 5;
        $sort = 'id';
        $direction = 'asc';
        $with = 'post';
        $comments = [new Comment(), new Comment()];

        $this->commentRepositoryMock->expects($this->once())
            ->method('getPaginated')
            ->with($this->equalTo($filters), $this->equalTo($page), $this->equalTo($limit), $this->equalTo($sort), $this->equalTo($direction), $this->equalTo($with))
            ->willReturn($comments);

        $result = $this->getCommentsUsecase->execute($filters, $page, $limit, $sort, $direction, $with);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Comment::class, $result[0]);
    }
}