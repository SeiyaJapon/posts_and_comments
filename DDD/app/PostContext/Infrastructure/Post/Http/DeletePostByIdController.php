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
        $success = $this->deletePostService->execute($id);

        return $success ?
            response()->json(['success' => $success]) :
            response()->json(['error' => 'Post not found'], Response::HTTP_NOT_FOUND);
    }
}