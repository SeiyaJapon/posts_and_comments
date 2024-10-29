<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Comment\Service;

use App\PostContext\Application\Comment\Command\CreateComment\CreateCommentCommand;
use App\PostContext\Application\Comment\Query\GetCommentByAbbreviation\GetCommentByAbbreviationQuery;
use App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQuery;
use App\PostContext\Domain\Comment\Comment;
use App\ShareContext\Infrastructure\CommandBus\CommandBusInterface;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;
use Ramsey\Uuid\Uuid;

class CreateCommentService
{
    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;

    public function __construct(CommandBusInterface $commandBus, QueryBusInterface $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function createComment(array $data): array
    {
        $validatedData = $data;

        $id = Uuid::uuid4()->toString();
        $content = $validatedData['content'];
        $postId = $validatedData['post_id'];
        $abbreviation = $validatedData['abbreviation'];

        $abbreviationExists = $this->queryBus->ask(new GetCommentByAbbreviationQuery($abbreviation));

        if ($abbreviationExists->result()['exists']) {
            throw new \Exception('Comment with abbreviation already exists');
        }

        $this->commandBus->handle(new CreateCommentCommand($id, $content, $postId, $abbreviation));

        $result = $this->queryBus->ask(new GetCommentByIdQuery($id));

        return [
            'comment' => $result->result(),
            'count' => 1
        ];
    }
}