<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Comment\Http;

use App\PostContext\Infrastructure\Comment\Service\CreateCommentService;
use App\PostContext\Infrastructure\Comment\Service\ValidateCreateDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateCommentController
{
    private CreateCommentService $createCommentService;
    private ValidateCreateDataService $validateCreateDataService;

    public function __construct(
        CreateCommentService $createCommentService,
        ValidateCreateDataService $validateCreateDataService
    ) {
        $this->createCommentService = $createCommentService;
        $this->validateCreateDataService = $validateCreateDataService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validatedData = $this->validateCreateDataService->validate($request);

            $result = $this->createCommentService->createComment($validatedData);

            return new JsonResponse($result, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}