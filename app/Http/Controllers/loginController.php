<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Autenticação
 *
 * Endpoints para gerenciar sessões de usuários e obtenção de tokens.
 */
class loginController extends Controller
{
    /**
     * Login de Usuário
     * 
     * Recebe as credenciais e retorna o token de acesso (Sanctum).
     * 
     * @response 200 {
     *  "token": "1|ra9vT8p2..."
     * }
     * @response 401 {
     *  "message": "Credenciais inválidas. Verifique seu e-mail e senha."
     * }
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $token = $user->createToken('auth_token');

            return response(['token' => $token->plainTextToken], 200);
        } else {
            return response()->json([
                'message' => 'Credenciais inválidas. Verifique seu e-mail e senha.'
            ], 401);
        }
    }

    /**
     * Logout de Usuário
     * 
     * Revoga o token de acesso atual do usuário.
     * @authenticated
     * 
     * @response 200 {
     *  "message": "Logout realizado com sucesso !"
     * }
     */
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso !'], 200);
    }
}
