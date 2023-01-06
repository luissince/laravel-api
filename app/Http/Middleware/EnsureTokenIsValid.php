<?php

namespace App\Http\Middleware;

use App\Exceptions\ServerErrorException;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Throwable;

class EnsureTokenIsValid
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
            JWT::decode($request->bearerToken(), new Key(env("JWT_KEY"), 'HS256'));
            return $next($request);
        } catch (ExpiredException $ex) {
            return response()->json(array('message' => 'Token expirado.'), 403);
        } catch (SignatureInvalidException $ex) {
            return response()->json(array('message' => 'Token invalido.'), 401);
        } catch (Throwable $ex) {
            throw new ServerErrorException('Error interno del servidor.');
        }
    }
}
