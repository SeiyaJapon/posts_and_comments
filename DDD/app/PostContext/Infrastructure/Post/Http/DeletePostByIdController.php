<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Post\Http;

use App\PostContext\Infrastructure\Post\Service\DeletePostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeletePostByIdController
{
    private DeletePostService $deletePostService;

    public function __construct(DeletePostService $deletePostService)
    {
        $this->deletePostService = $deletePostService;
    }

    public function __invoke(string $id): JsonResponse
    {
        try {
            $this->deletePostService->execute($id);

            return new JsonResponse(true, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}