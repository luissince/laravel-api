<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return $this->user()->can('signup', User::class);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email',  'max:255', 'unique:users,email'],
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ];
    }
}
