<?php

declare (strict_types=1);

namespace Tests\Unit\Usecases\Post;

use PHPUnit\Framework\TestCase;
use App\Usecases\Post\DeletePostUsecase;
use App\Repositories\PostRepository;

class DeletePostUsecaseTest extends TestCase
{
    private $postRepositoryMock;
    private $deletePostUsecase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepositoryMock = $this->createMock(PostRepository::class);

        $this->deletePostUsecase = new DeletePostUsecase($this->postRepositoryMock);
    }

    public function testExecute()
    {
        $this->postRepositoryMock->expects($this->once())
            ->method('deletePost')
            ->with($this->equalTo(1))
            ->willReturn(true);

        $result = $this->deletePostUsecase->execute(1);

        $this->assertTrue($result);
    }

    public function testExecutePostNotFound()
    {
        $this->postRepositoryMock->expects($this->once())
            ->method('deletePost')
            ->with($this->equalTo(999))
            ->willReturn(false);

        $result = $this->deletePostUsecase->execute(999);

        $this->assertFalse($result);
    }

    public function testExecuteDeletionFails()
    {
        $this->postRepositoryMock->expects($this->once())
            ->method('deletePost')
            ->with($this->equalTo(1))
            ->willReturn(false);

        $result = $this->deletePostUsecase->execute(1);

        $this->assertFalse($result);
    }
}