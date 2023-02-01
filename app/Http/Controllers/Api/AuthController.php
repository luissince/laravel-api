<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AuthenticateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth:sanctum")->except(["login"]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where("email", "=", $request->email)->first();

        if (!isset($user->id)) {
            throw new AuthenticateException("El email no existe.");
        }

        if (!Hash::check($request->password, $user->password)) {
            throw new AuthenticateException("La contraseña es incorrecta.");
        }

        $token = $user->createToken("auth_token")->plainTextToken;
        return response(compact('user', 'token'), 200);
    }

    public function logout(Request $request)
    {
        // Get user who requested the logout
        // $user = request()->user(); //or Auth::user()

        // Revoke current user token
        // $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        return response("", 204);
    }
}
