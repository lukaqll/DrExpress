<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            if ( !$token = auth('api')->attempt($credentials) ) {
                return response()->json(['status' => 'error', 'message' => 'E-mail ou senha incorretos'], 401);
            }
            return $this->respondWithToken($token);
        } catch (ValidationException $e ){
            return response()->json(['status' => 'error', 'message' => $e->errors()], 401);
        }

    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth('api')->user();

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['status' => 'success', 'message' => 'Logout realizado conm sucesso']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        if( auth('api')->check() ){
            $result = ['status' => 'success', 'data' => auth('api')->user()];
        } else {
            $result = ['status' => 'error', 'message' => 'Sem Autorização'];
        }
        return response()->json($result);
    }

}
