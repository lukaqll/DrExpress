<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class ApiMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch ( \Exception $e ){

            if ($e instanceof TokenInvalidException){
                $response = ['status' => 'error', 'message' => 'Sem Autorização'];
            }else if ($e instanceof TokenExpiredException){
                $response = ['status' => 'error', 'message' => 'Autorização Expirada'];
            }else{
                $response = ['status' => 'error', 'message' => $e->getMessage()];
            }

            throw new HttpException(403, $response['message']);
            return response()->json($response);
        }

        return $next( $request );
    }
}
