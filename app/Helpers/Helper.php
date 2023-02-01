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

    public static function encriptar(string $data)
    {
        $ciphering = "AES-128-CTR";
        openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = 'w0MIPD7bk6qVVB7';
        $encryption = openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryption;
    }
}
