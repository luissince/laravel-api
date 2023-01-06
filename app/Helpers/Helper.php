<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Helper
{
    public static function tokenDecode(string $token)
    {
        $decode = JWT::decode($token, new Key(env("JWT_KEY"), 'HS256'));
        return $decode->data->idusuario;
    }
}
