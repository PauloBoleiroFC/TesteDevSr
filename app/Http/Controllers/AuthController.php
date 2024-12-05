<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Authors",
 *     description="Endpoints relacionados à autenticação de usuários."
 * )
 */
class AuthController extends Controller
{
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Realiza o login do usuário.
     *
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="Login do usuário",
     *     description="Autentica o usuário e retorna um token JWT.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token JWT gerado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao tentar criar o token."
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível criar o token'], 500);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * Realiza o logout do usuário.
     *
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     summary="Logout do usuário",
     *     description="Invalida o token JWT do usuário autenticado.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout realizado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout realizado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao tentar realizar o logout."
     *     )
     * )
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Logout realizado com sucesso']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Falha ao realizar logout'], 500);
        }
    }

    /**
     * Registra um novo usuário.
     *
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="Registro de usuário",
     *     description="Cria um novo usuário no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário registrado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Record saved successfully!"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao tentar registrar o usuário."
     *     )
     * )
     */
    public function register(UserRequest $request)
    {
        try {
            $user = $this->userRepository->create($request->input());

            return response()->json([
                'success' => true,
                'message' => 'Record saved successfully!',
                'data' => $user,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error trying to save.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
