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
     * @return void
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
