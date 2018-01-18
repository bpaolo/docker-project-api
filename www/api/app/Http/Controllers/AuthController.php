<?php

namespace App\Http\Controllers;
// Helpers
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Responses\ResponseJson;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        // Instancia Response
        $response  = new ResponseJson();
        // Recupera o Request com E-mail e Password
        $credentials = $request->only('email', 'password');
        // Valida se as credenciais são válidas
        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }
        return $response->setResponse(401, null, null);
    }
    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        // Instancia Response
        $response  = new ResponseJson();
        // Seta a Variável Data
        $data = [
            $this->guard()->user()
        ];
        // Retorna a resposta
        return $response->setResponse(200, null, $data);
    }
    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        // Logout do Usuário
        $this->guard()->logout();
        // Instancia Response
        $response  = new ResponseJson();
        // Seta mensagem de erro
        $messages = [
            'message' => 'Logout com sucesso!'
        ];
        // Retorna a resposta
        return $response->setResponse(200, null, null);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken($this->guard()->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        // Instancia Response
        $response  = new ResponseJson();
        // Seta a Variável data;
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
        // Retorna Token
        return $response->setResponse(200, null, $data);
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard() {
        return Auth::guard();
    }
}