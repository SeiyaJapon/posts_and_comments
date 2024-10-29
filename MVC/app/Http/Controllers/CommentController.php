<?php

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Usecases\Comment\CreateCommentUsecase;
use App\Usecases\Comment\DeleteCommentUsecase;
use App\Usecases\Comment\GetCommentByIdUsecase;
use App\Usecases\Comment\GetCommentsUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private CreateCommentUsecase $createCommentUsecase;
    private DeleteCommentUsecase $deleteCommentUsecase;
    private GetCommentByIdUsecase $getCommentByIdUsecase;
    private GetCommentsUsecase $getCommentsUsecase;

    public function __construct(
        CreateCommentUsecase $createCommentUsecase,
        DeleteCommentUsecase $deleteCommentUsecase,
        GetCommentByIdUsecase $getCommentByIdUsecase,
        GetCommentsUsecase $getCommentsUsecase
    ) {
        $this->createCommentUsecase = $createCommentUsecase;
        $this->deleteCommentUsecase = $deleteCommentUsecase;
        $this->getCommentByIdUsecase = $getCommentByIdUsecase;
        $this->getCommentsUsecase = $getCommentsUsecase;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->except(['page', 'limit', 'sort', 'direction', 'with']);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
        $with = $request->query('with', null);

        $comments = $this->getCommentsUsecase->execute(
            $filters,
            intval($page),
            intval($limit),
            $sort,
            $direction,
            $with
        );

        return response()->json([
            'result' => $comments['result'],
            'count' => $comments['count']
        ]);
    }

    public function show(int $id, Request $request): JsonResponse
    {
        $with = $request->get('with', null);
        $comment = $this->getCommentByIdUsecase->execute($id, $with);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        return response()->json(['result' => $comment, 'count' => 1]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->deleteCommentUsecase->execute($id);

        if (!$deleted) {
            return response()->json(['error' => 'Comment not found or could not be deleted'], 404);
        }

        return response()->json(['success' => true]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
            'abbreviation' => 'required|string'
        ]);

        $comment = $this->createCommentUsecase->execute($validatedData);

        return response()->json(['result' => $comment, 'count' => 1], 201);
    }
}