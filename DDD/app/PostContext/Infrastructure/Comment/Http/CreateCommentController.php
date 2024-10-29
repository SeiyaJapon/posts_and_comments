<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Infrastructure\Comment\Service\CreateCommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class CreateCommentController
{
    private CreateCommentService $createCommentService;

    public function __construct(CreateCommentService $createCommentService)
    {
        $this->createCommentService = $createCommentService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'post_id' => 'required|exists:posts,id',
                'content' => 'required|string',
                'abbreviation' => 'required|string',
            ]);

            $result = $this->createCommentService->createComment($validatedData);

            return response()->json($result, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}