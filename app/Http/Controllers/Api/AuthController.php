<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AuthenticateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return response()->json([
                "message" => "El email no existe."
            ], 400);
            //throw new AuthenticateException("La password es incorrecta");
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "La contraseña es incorrecta."
            ], 400);
        }

        $token = $user->createToken("auth_token")->plainTextToken;
        return response(compact('user', 'token'), 200);
        //throw new AuthenticateException("Usuario no registrado");
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
