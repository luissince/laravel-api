<?php

namespace App\Http\Controllers\Session;

use App\Exceptions\AuthenticateException;
use App\Exceptions\ServerErrorException;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware("token")->except(["login"]);
    }

    public function login(Request $request)
    {
        try {
            $user = DB::table('usuario')
                ->where('email', $request->email)
                ->where('password',  $request->password)
                ->where('estado', 'activo')
                ->first();

            if (is_null($user)) {
                throw new AuthenticateException('Error Email/Password');
            }

            $time = time();

            $token = array(
                "iat" => $time,
                "exp" => $time + intval(env("JWT_EXPIRATION")),
                "data" => [
                    "idusuario" => $user->idusuario
                ]
            );

            $jwt = JWT::encode($token, env("JWT_KEY"), 'HS256');
            return response()->json(array('user' => (object)array(
                "idusuario" => $user->idusuario,
            ), "token" => $jwt));
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            throw new ServerErrorException('Error interno del servidor.');
        }
    }

    public function logout(Request $request)
    {
        return response()->json(array('message' => 'Sessión cerrada.'), 204);
    }

    public function validtoken(Request $request){
        return response()->json(array('message' => 'Token valido.'));
    }

    public function contribuyente(Request $request)
    {
        try {
            $idusuario = Helper::tokenDecode($request->bearerToken());

            $user = DB::table('usuario')
                ->where('idusuario', $idusuario)
                ->first();

            $rol = DB::table('rol_usuario')->where("id_rol", $user->id_rol)->first();
            if (is_null($rol)) {
                throw new AuthenticateException('Error en obtener los roles.');
            }

            $contribuyente = DB::table('contribuyente')->where("id_contribuyente", $user->id_contribuyente)->first();
            if (is_null($contribuyente)) {
                throw new AuthenticateException('Error en obtener los datos del contribuyente.');
            }

            return response()->json([
                "idusuario" => $user->idusuario,
                "codigo" => $user->codigo,
                "nombre" => $user->nombre,
                "apellido" => $user->apellido,
                "celular" => $user->celular,
                "telefono" => $user->telefono,
                "id_rol" => $user->id_rol,
                "rol" => $rol->nombre,
                "rol_alias" => $rol->alias,
                "email" => $user->email,
                "url_image" => $user->url_image,
                "ruc" => $contribuyente->ruc,
                "razon_social" => $contribuyente->razon_social,
                "img_logo" => $contribuyente->img_logo,
                "dominio" => $contribuyente->dominio,
            ]);
        } catch (PDOException $ex) {
            throw new ServerErrorException('Error interno del servidor.');
        }
    }
}
