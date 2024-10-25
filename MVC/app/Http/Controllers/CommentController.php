<?php

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->except(['page', 'limit', 'sort', 'direction', 'with']);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        $comments = $this->commentService->getComments($filters, intval($page), intval($limit), $sort, $direction);

        return response()->json([
            'result' => $comments['result'],
            'count' => $comments['count']
        ]);
    }

    public function show(int $id, Request $request): JsonResponse
    {
        $with = $request->get('with', '');
        $comment = $this->commentService->getCommentById($id, $with);
        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }
        return response()->json($comment);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->commentService->deleteComment($id);

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

        $comment = $this->commentService->createComment($validatedData);

        return response()->json($comment, 201);
    }
}