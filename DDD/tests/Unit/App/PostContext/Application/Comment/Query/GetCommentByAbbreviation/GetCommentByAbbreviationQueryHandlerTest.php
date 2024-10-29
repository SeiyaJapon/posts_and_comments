<?php

declare(strict_types=1);

namespace Tests\Unit\App\PostContext\Application\Comment\Query\GetCommentByAbbreviation;

use App\PostContext\Application\Comment\Query\GetCommentByAbbreviation\GetCommentByAbbreviationQuery;
use App\PostContext\Application\Comment\Query\GetCommentByAbbreviation\GetCommentByAbbreviationQueryHandler;
use App\PostContext\Application\Comment\Query\GetCommentByAbbreviation\GetCommentByAbbreviationQueryResult;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetCommentByAbbreviationQueryHandlerTest extends TestCase
{
    private $commentRepositoryMock;
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentRepositoryMock = $this->createMock(CommentRepositoryInterface::class);
        $this->handler = new GetCommentByAbbreviationQueryHandler($this->commentRepositoryMock);
    }

    public function test_handle_returns_true_when_comment_exists()
    {
        $abbreviation = 'existing-abbreviation';
        $query = new GetCommentByAbbreviationQuery($abbreviation);

        $this->commentRepositoryMock->expects($this->once())
            ->method('existsByAbbreviation')
            ->with($this->equalTo($abbreviation))
            ->willReturn(true);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetCommentByAbbreviationQueryResult::class, $result);
    }

    public function test_handle_returns_false_when_comment_does_not_exist()
    {
        $abbreviation = 'non-existent-abbreviation';
        $query = new GetCommentByAbbreviationQuery($abbreviation);

        $this->commentRepositoryMock->expects($this->once())
            ->method('existsByAbbreviation')
            ->with($this->equalTo($abbreviation))
            ->willReturn(false);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetCommentByAbbreviationQueryResult::class, $result);
    }
}