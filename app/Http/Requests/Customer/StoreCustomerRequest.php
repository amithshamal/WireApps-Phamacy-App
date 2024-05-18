<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers',
            'phone' => 'nullable|string|max:255',
        ];
    }
}
