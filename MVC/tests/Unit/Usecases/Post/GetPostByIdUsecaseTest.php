<?php

declare (strict_types=1);

namespace Tests\Unit\Usecases\Post;

use PHPUnit\Framework\TestCase;
use App\Usecases\Post\GetPostByIdUsecase;
use App\Repositories\PostRepository;
use App\Models\Post\Post;

class GetPostByIdUsecaseTest extends TestCase
{
    private $postRepositoryMock;
    private $getPostByIdUsecase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepositoryMock = $this->createMock(PostRepository::class);

        $this->getPostByIdUsecase = new GetPostByIdUsecase($this->postRepositoryMock);
    }

    public function testExecute()
    {
        $post = new Post();
        $post->id = 1;

        $this->postRepositoryMock->expects($this->once())
            ->method('getPostById')
            ->with($this->equalTo(1))
            ->willReturn($post);

        $result = $this->getPostByIdUsecase->execute(1);

        $this->assertInstanceOf(Post::class, $result);
        $this->assertEquals(1, $result->id);
    }

    public function testExecutePostNotFound()
    {
        $this->postRepositoryMock->expects($this->once())
            ->method('getPostById')
            ->with($this->equalTo(999))
            ->willReturn(null);

        $result = $this->getPostByIdUsecase->execute(999);

        $this->assertNull($result);
    }
}