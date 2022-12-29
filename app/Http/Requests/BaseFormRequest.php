<?php

namespace App\Http\Requests;

use App\Exceptions\JsonAuthorizationException;
use App\Exceptions\JsonValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \App\Exceptions\JsonAuthorizationException
     */
    protected function failedAuthorization()
    {
       throw new JsonAuthorizationException();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \App\Exceptions\JsonValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new JsonValidationException($validator);
    }
}
