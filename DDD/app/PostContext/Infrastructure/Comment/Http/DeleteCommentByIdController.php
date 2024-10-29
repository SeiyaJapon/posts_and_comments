<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Application\Comment\Command\DeleteCommentById\DeleteCommentByIdCommand;
use App\ShareContext\Infrastructure\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteCommentByIdController
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $commentId): JsonResponse
    {
        try {
            $this->commandBus->handle(new DeleteCommentByIdCommand($commentId));

            return new JsonResponse(true, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }
}