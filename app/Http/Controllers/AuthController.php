<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthUserResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
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

            $user = $this->userService->get(['email' => $credentials['email']]);

            if( empty($user) )
                $this->throwException('E-mail ou senha incorretos'); 

            if( $user->status == 'I' )
                $this->throwException('Usuário inativo'); 

            if ( !$token = auth('api')->attempt($credentials, ['exp' => Carbon::now()->addDays(7)->timestamp]) ) {
                return response()->json(['status' => 'error', 'message' => 'E-mail ou senha incorretos']);
            }

            

            return $this->respondWithToken($token);
        } catch (ValidationException $e ){
            return response()->json(['status' => 'error', 'message' => $e->errors()]);
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
                'user' => new AuthUserResource($user),
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
            $result = ['status' => 'success', 'data' => new AuthUserResource( auth('api')->user())];
        } else {
            $result = ['status' => 'error', 'message' => 'Sem Autorização'];
        }
        return response()->json($result);
    }

}
