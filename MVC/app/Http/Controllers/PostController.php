<?php

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->except(['page', 'limit', 'sort', 'direction']);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        $posts = $this->postService->getPosts($filters, intval($page), intval($limit), $sort, $direction);

        return response()->json([
            'result' => $posts['result'],
            'count' => $posts['count']
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getPostById($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->postService->deletePost($id);

        if (!$deleted) {
            return response()->json(['error' => 'Post not found or could not be deleted'], 404);
        }

        return response()->json(['success' => true]);
    }
}