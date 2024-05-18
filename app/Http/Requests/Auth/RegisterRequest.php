<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;


class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required',
            'username' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'user_role' => 'required|in:manager,cashier'
        ];
    }

    public function failedValidation(Validator $validator){
        Helper::sendError('Request validation error',$validator->errors());
    }
}
