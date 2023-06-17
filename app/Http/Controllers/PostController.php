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
    * @OA\Get(
    *    tags={"/posts"},
    *    path="/posts",
    *    summary="Listar Posts",
    *    security={{ "bearerAuth" : {} }},
    *    @OA\Response(
    *        response="200",
    *        description="Lista de Posts.",
    *    ),
    *    @OA\Response(
    *        response="401",
    *        description="Não autorizado.",
    *    )
    * )
    *
    * @return JsonResponse
    */
    public function index(): JsonResponse
    {
        $posts = Post::with(['user'])->get();

        return response()->json($posts, 200);
    }

    /**
     * Store post
     *
     * @param StorePostRequest $request
     *
     * @OA\Post(
     *    tags={"/posts"},
     *    path="/posts",
     *    summary="Cadastrar Post",
     *    security={{ "bearerAuth" : {} }},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="title", type="string"),
     *           @OA\Property(property="slug", type="string"),
     *           @OA\Property(property="content", type="string"),
     *        )
     *    ),
     *    @OA\Response(
     *        response="201",
     *        description="Post Created",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="id", type="int"),
     *            @OA\Property(property="title", type="string"),
     *            @OA\Property(property="slug", type="string"),
     *            @OA\Property(property="content", type="string"),
     *            @OA\Property(property="created_at", type="string"),
     *            @OA\Property(property="updated_at", type="string"),
     *        )
     *    ),
     *    @OA\Response(
     *        response="401",
     *        description="Não autorizado.",
     *    ),
     *    @OA\Response(
     *        response="422",
     *        description="Conteúdo não processado.",
     *    ),
     * )
     *
     * @return JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = Post::create($request->all());
        $post = Post::with(['user'])->find($post->id);

        return response()->json($post, 201);
    }

    /**
     * Show post by id
     *
     * @OA\Get(
     *    tags={"/posts"},
     *    summary="Mostrar Post pelo id",
     *    path="/posts/{id}",
     *    description="Mostrar Post",
     *    security={{ "bearerAuth" : {}}},
     *    @OA\Parameter(
     *          description="Post Id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *    ),
     *    @OA\Response(
     *        response="200",
     *        description="Post Created",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="id", type="int"),
     *            @OA\Property(property="title", type="string"),
     *            @OA\Property(property="slug", type="string"),
     *            @OA\Property(property="content", type="string"),
     *            @OA\Property(property="created_at", type="string"),
     *            @OA\Property(property="updated_at", type="string"),
     *        )
     *    ),
     *    @OA\Response(
     *        response="401",
     *        description="Não autorizado.",
     *    ),
     *    @OA\Response(
     *        response="404",
     *        description="Post não encontrado.",
     *    ),
     * )
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $post = Post::with(['user'])->findOrFail($id);

        return response()->json($post, 200);
    }

    /**
     * Update specific post on storage
     *
     * @OA\Put(
     *    tags={"/posts"},
     *    path="/posts/{id}",
     *    summary="Editar Post",
     *    security={{ "bearerAuth" : {} }},
     *    @OA\Parameter(
     *       description="Post Id",
     *       in="path",
     *       name="id",
     *       required=true,
     *       @OA\Schema(
     *           type="integer",
     *           format="int64"
     *       )
     *    ),
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="title", type="string"),
     *           @OA\Property(property="slug", type="string"),
     *           @OA\Property(property="content", type="string"),
     *        )
     *    ),
     *    @OA\Response(
     *        response="200",
     *        description="Post Updated",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="id", type="int"),
     *            @OA\Property(property="title", type="string"),
     *            @OA\Property(property="slug", type="string"),
     *            @OA\Property(property="content", type="string"),
     *            @OA\Property(property="created_at", type="string"),
     *            @OA\Property(property="updated_at", type="string"),
     *        )
     *    ),
     *    @OA\Response(
     *        response="401",
     *        description="Não autorizado.",
     *    ),
     *    @OA\Response(
     *        response="404",
     *        description="Post não encontrado.",
     *    ),
     *    @OA\Response(
     *        response="422",
     *        description="Conteúdo não processado.",
     *    ),
     * )
     *
     * @param StorePostRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(StorePostRequest $request, string $id): JsonResponse
    {
        $post = Post::with(['user'])->findOrFail($id);
        $post->update($request->all());

        return response()->json($post, 200);
    }

    /**
     * Delete post
     *
     * @OA\Delete(
     *    tags={"/posts"},
     *    path="/posts/{id}",
     *    summary="Deletar Post",
     *    security={{ "bearerAuth" : {} }},
     *    @OA\Parameter(
     *          description="Post Id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *    ),
     *    @OA\Response(
     *        response="200",
     *        description="Post Deleted",
     *    ),
     *    @OA\Response(
     *        response="401",
     *        description="Não autorizado.",
     *    ),
     *    @OA\Response(
     *        response="422",
     *        description="Conteúdo não processado.",
     *    ),
     * )
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([], 200);
    }
}
