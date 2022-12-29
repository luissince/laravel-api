<?php

namespace App\Exceptions;

use Exception;

class JsonAuthorizationException extends Exception
{
    protected $message = 'Not authorized';

    public function report()
    {
        return false;
    }

    public function render($request)
    {
        return response()->json([
            "message" => $this->message
        ], 403);
    }
}
