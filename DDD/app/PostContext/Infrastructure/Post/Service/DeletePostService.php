<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Post\Service;

use App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommand;
use App\PostContext\Application\Post\Query\PostExists\PostExistsQuery;
use App\ShareContext\Infrastructure\CommandBus\CommandBusInterface;
use App\ShareContext\Infrastructure\QueryBus\QueryBusInterface;

class DeletePostService
{
    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;

    public function __construct(CommandBusInterface $commandBus, QueryBusInterface $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function execute(string $id): bool
    {
        try {
            $this->commandBus->handle(new DeletePostByIdCommand($id));

            $exists = $this->queryBus->ask(new PostExistsQuery($id));

            return !$exists->result()['exists'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}