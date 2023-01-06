<?php

namespace App\Exceptions;

use Exception;

class ServerErrorException extends Exception
{
    protected $message = 'ServerErrorException';

    public function report()
    {
        return false;
    }

    public function render($request)
    {
        return response()->json(["message" => $this->message], 500);
    }
}
