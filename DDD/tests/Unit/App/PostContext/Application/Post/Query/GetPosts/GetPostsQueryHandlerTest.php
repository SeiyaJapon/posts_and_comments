<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Application\Post\Query\GetPosts;

use App\PostContext\Application\Post\Query\GetPosts\GetPostsQuery;
use App\PostContext\Application\Post\Query\GetPosts\GetPostsQueryHandler;
use App\PostContext\Application\Post\Query\GetPosts\GetPostsQueryResult;
use App\PostContext\Domain\Post\PostRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetPostsQueryHandlerTest extends TestCase
{
    private $postRepositoryMock;
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepositoryMock = $this->createMock(PostRepositoryInterface::class);
        $this->handler = new GetPostsQueryHandler($this->postRepositoryMock);
    }

    public function test_handle_returns_posts_successfully()
    {
        $filters = ['author' => 'author-id'];
        $page = 1;
        $limit = 10;
        $sort = 'created_at';
        $direction = 'desc';
        $commentFilter = 'approved';
        $with = 'comments';
        $query = new GetPostsQuery($filters, $page, $limit, $sort, $direction, $commentFilter, $with);
        $posts = [
            ['id' => 'post-id-1', 'title' => 'Test Post 1'],
            ['id' => 'post-id-2', 'title' => 'Test Post 2']
        ];

        $this->postRepositoryMock->expects($this->once())
            ->method('getPosts')
            ->with(
                $this->equalTo($filters),
                $this->equalTo($page),
                $this->equalTo($limit),
                $this->equalTo($sort),
                $this->equalTo($direction),
                $this->equalTo($commentFilter),
                $this->equalTo($with)
            )
            ->willReturn($posts);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetPostsQueryResult::class, $result);
        $this->assertEquals($posts, $result->result());
    }

    public function test_handle_returns_empty_array_when_no_posts_found()
    {
        $filters = ['author' => 'author-id'];
        $page = 1;
        $limit = 10;
        $sort = 'created_at';
        $direction = 'desc';
        $commentFilter = 'approved';
        $with = 'comments';
        $query = new GetPostsQuery($filters, $page, $limit, $sort, $direction, $commentFilter, $with);

        $this->postRepositoryMock->expects($this->once())
            ->method('getPosts')
            ->with(
                $this->equalTo($filters),
                $this->equalTo($page),
                $this->equalTo($limit),
                $this->equalTo($sort),
                $this->equalTo($direction),
                $this->equalTo($commentFilter),
                $this->equalTo($with)
            )
            ->willReturn([]);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetPostsQueryResult::class, $result);
        $this->assertEquals([], $result->result());
    }
}