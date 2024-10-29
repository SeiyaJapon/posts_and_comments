<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Application\Comment\Query\GetComments;

use App\PostContext\Application\Comment\Query\GetComments\GetCommentsQuery;
use App\PostContext\Application\Comment\Query\GetComments\GetCommentsQueryHandler;
use App\PostContext\Application\Comment\Query\GetComments\GetCommentsQueryResult;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetCommentsQueryHandlerTest extends TestCase
{
    private $commentRepositoryMock;
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepositoryInterface::class);
        $this->handler = new GetCommentsQueryHandler($this->commentRepositoryMock);
    }

    public function test_handle_returns_comments_successfully()
    {
        $filters = ['post_id' => 'post-id'];
        $page = 1;
        $limit = 10;
        $sort = 'created_at';
        $direction = 'desc';
        $with = 'author';
        $query = new GetCommentsQuery($filters, $page, $limit, $sort, $direction, $with);
        $comments = [
            ['id' => 'comment-id-1', 'content' => 'Test Comment 1'],
            ['id' => 'comment-id-2', 'content' => 'Test Comment 2']
        ];

        $this->commentRepositoryMock->expects($this->once())
            ->method('getComments')
            ->with(
                $this->equalTo($filters),
                $this->equalTo($page),
                $this->equalTo($limit),
                $this->equalTo($sort),
                $this->equalTo($direction),
                $this->equalTo($with)
            )
            ->willReturn($comments);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetCommentsQueryResult::class, $result);
        $this->assertEquals($comments, $result->result());
    }

    public function test_handle_returns_empty_array_when_no_comments_found()
    {
        $filters = ['post_id' => 'post-id'];
        $page = 1;
        $limit = 10;
        $sort = 'created_at';
        $direction = 'desc';
        $with = 'author';
        $query = new GetCommentsQuery($filters, $page, $limit, $sort, $direction, $with);

        $this->commentRepositoryMock->expects($this->once())
            ->method('getComments')
            ->with(
                $this->equalTo($filters),
                $this->equalTo($page),
                $this->equalTo($limit),
                $this->equalTo($sort),
                $this->equalTo($direction),
                $this->equalTo($with)
            )
            ->willReturn([]);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetCommentsQueryResult::class, $result);
        $this->assertEquals([], $result->result());
    }
}