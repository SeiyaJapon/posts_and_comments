<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Post\Service;

use App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommand;
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

    public function execute(string $id): void
    {
        $this->commandBus->handle(new DeletePostByIdCommand($id));
    }
}