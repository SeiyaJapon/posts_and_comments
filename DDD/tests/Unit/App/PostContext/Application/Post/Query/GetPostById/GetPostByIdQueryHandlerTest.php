<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Application\Post\Query\GetPostById;

use App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQuery;
use App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQueryHandler;
use App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQueryResult;
use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetPostByIdQueryHandlerTest extends TestCase
{
    private $postRepositoryMock;
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepositoryMock = $this->createMock(PostRepositoryInterface::class);
        $this->handler = new GetPostByIdQueryHandler($this->postRepositoryMock);
    }

    public function test_handle_returns_post_successfully()
    {
        $postId = Uuid::uuid4()->toString();
        $with = 'comments';
        $query = new GetPostByIdQuery($postId, $with);
        $post = new \App\Models\Post\Post([
            'id' => $postId,
            'title' => 'Test Post',
            'content' => 'content',
            'abbreviation' => 'abbreviation',
        ]);

        $this->postRepositoryMock->expects($this->once())
            ->method('getPostById')
            ->with($this->equalTo(new PostId($postId)), $this->equalTo($with))
            ->willReturn($post);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetPostByIdQueryResult::class, $result);
        $this->assertEquals(['id' => $postId, 'title' => 'Test Post', 'content' => 'content'], $result->result());
    }

    public function test_handle_throws_exception_when_post_not_found()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Post not found');
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $postId = Uuid::uuid4()->toString();
        $with = 'comments';
        $query = new GetPostByIdQuery($postId, $with);

        $this->postRepositoryMock->expects($this->once())
            ->method('getPostById')
            ->with($this->equalTo(new PostId($postId)), $this->equalTo($with))
            ->willReturn(null);

        $this->handler->handle($query);
    }
}