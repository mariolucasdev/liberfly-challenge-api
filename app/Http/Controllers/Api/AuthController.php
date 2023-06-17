<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{Auth, Hash, Validator};

class AuthController extends Controller
{
    /**
     * create user
     *
     * @param CreateUserRequest $request
     *
     * @OA\Post(
     *      tags={"Cadastro e Autenticação"},
     *      path="/auth/register",
     *      summary="Registrar um Novo Usuário",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="email"),
     *              @OA\Property(property="password", type="password"),
     *          )
     *      ),
     *      @OA\Response(
     *              response="201",
     *              description="Responde com um objeto json contendo: stauts, message e token em caso de sucesso; Em caso de erro, retorno um objecto json contendo: status e message. ",
     *              @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="status", type="bool"),
     *                  @OA\Property(property="message", type="string"),
     *                  @OA\Property(property="token", type="string"),
     *              )
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $response = [
            'status' => true,
            'message' => 'Usuário cadastrado com sucesso!',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ];

        return response()->json($response, 201);
    }

    /**
     * login user
     *
     * @param Request $request
     *
     * * @OA\Post(
     *      tags={"Cadastro e Autenticação"},
     *      path="/auth/login",
     *      summary="Realiza o Login do Usuário",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="email"),
     *              @OA\Property(property="password", type="password"),
     *          )
     *      ),
     *      @OA\Response(
     *              response="201",
     *              description="Responde com um objeto json contendo: stauts, message e token em caso de sucesso; Em caso de erro, retorno um objecto json contendo: status e message. ",
     *              @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="status", type="bool"),
     *                  @OA\Property(property="message", type="string"),
     *                  @OA\Property(property="token", type="string"),
     *              )
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function loginUser(LoginUserRequest $request): JsonResponse
    {
        if(!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário e/ou senha incorreto(s).',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => true,
            'message' => 'Login realizado com sucesso!',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }
}
