<?php

declare (strict_types=1);

namespace Tests\Unit\Usecases\Post;

use PHPUnit\Framework\TestCase;
use App\Usecases\Post\GetPostsUsecase;
use App\Repositories\PostRepository;
use App\Models\Post\Post;

class GetPostsUsecaseTest extends TestCase
{
    private $postRepositoryMock;
    private $getPostsUsecase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepositoryMock = $this->createMock(PostRepository::class);

        $this->getPostsUsecase = new GetPostsUsecase($this->postRepositoryMock);
    }

    public function testExecute()
    {
        $posts = [new Post(), new Post()];

        $this->postRepositoryMock->expects($this->once())
            ->method('getPosts')
            ->with($this->equalTo([]), $this->equalTo(1), $this->equalTo(10), $this->equalTo('id'), $this->equalTo('asc'), $this->equalTo(null))
            ->willReturn($posts);

        $result = $this->getPostsUsecase->execute();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Post::class, $result[0]);
    }

    public function testExecuteWithFilters()
    {
        $filters = ['author' => 'John Doe'];
        $posts = [new Post()];

        $this->postRepositoryMock->expects($this->once())
            ->method('getPosts')
            ->with($this->equalTo($filters), $this->equalTo(1), $this->equalTo(10), $this->equalTo('id'), $this->equalTo('asc'), $this->equalTo(null))
            ->willReturn($posts);

        $result = $this->getPostsUsecase->execute($filters);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Post::class, $result[0]);
    }

    public function testExecuteWithPagination()
    {
        $posts = [new Post(), new Post()];

        $this->postRepositoryMock->expects($this->once())
            ->method('getPosts')
            ->with($this->equalTo([]), $this->equalTo(2), $this->equalTo(5), $this->equalTo('id'), $this->equalTo('asc'), $this->equalTo(null))
            ->willReturn($posts);

        $result = $this->getPostsUsecase->execute([], 2, 5);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Post::class, $result[0]);
    }

    public function testExecuteWithSorting()
    {
        $posts = [new Post(), new Post()];

        $this->postRepositoryMock->expects($this->once())
            ->method('getPosts')
            ->with($this->equalTo([]), $this->equalTo(1), $this->equalTo(10), $this->equalTo('title'), $this->equalTo('desc'), $this->equalTo(null))
            ->willReturn($posts);

        $result = $this->getPostsUsecase->execute([], 1, 10, 'title', 'desc');

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Post::class, $result[0]);
    }

    public function testExecuteWithCommentFilter()
    {
        $filters = ['comment' => 'Great post'];
        $posts = [new Post()];

        $this->postRepositoryMock->expects($this->once())
            ->method('getPosts')
            ->with($this->equalTo([]), $this->equalTo(1), $this->equalTo(10), $this->equalTo('id'), $this->equalTo('asc'), $this->equalTo('Great post'))
            ->willReturn($posts);

        $result = $this->getPostsUsecase->execute($filters);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Post::class, $result[0]);
    }
}