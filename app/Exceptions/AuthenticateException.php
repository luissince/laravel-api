<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Exception;

class AuthenticateException extends Exception
{

    protected $message = 'AuthenticateException';

    public function report(){
        return false;
    }

    public function render($request){
        return response()->json(["message" => $this->message],401);
    }

}
