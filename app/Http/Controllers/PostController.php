<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the posts
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $posts = Post::all();

        return response()->json($posts, 200);
    }

    /**
     * Store post
     *
     * @param StorePostRequest $request
     * @return JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = Post::create($request->all());

        return response()->json($post, 201);
    }

    /**
     * Show post by id
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $post = Post::findOrFail($id);

        return response()->json($post, 200);
    }

    /**
     * Update specific post on storage
     *
     * @param StorePostRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(StorePostRequest $request, string $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        
        return response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([], 204);
    }
}
