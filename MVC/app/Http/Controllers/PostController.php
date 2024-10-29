<?php

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Usecases\Post\DeletePostUsecase;
use App\Usecases\Post\GetPostByIdUsecase;
use App\Usecases\Post\GetPostsUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private GetPostsUsecase $getPostsUsecase;
    private GetPostByIdUsecase $getPostByIdUsecase;
    private DeletePostUsecase $deletePostUsecase;

    public function __construct(
        GetPostsUsecase $getPostsUsecase,
        GetPostByIdUsecase $getPostByIdUsecase,
        DeletePostUsecase $deletePostUsecase
    ) {
        $this->getPostsUsecase = $getPostsUsecase;
        $this->getPostByIdUsecase = $getPostByIdUsecase;
        $this->deletePostUsecase = $deletePostUsecase;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->except(['page', 'limit', 'sort', 'direction', 'with']);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
        $with = $request->get('with', null);

        $posts = $this->getPostsUsecase->execute($filters, intval($page), intval($limit), $sort, $direction, $with);

        return response()->json([
            'result' => $posts['result'],
            'count' => $posts['count']
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->getPostByIdUsecase->execute($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json(['result' => $post, 'count' => 1]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->deletePostUsecase->execute($id);

        if (!$deleted) {
            return response()->json(['error' => 'Post not found or could not be deleted'], 404);
        }

        return response()->json(['success' => true]);
    }
}