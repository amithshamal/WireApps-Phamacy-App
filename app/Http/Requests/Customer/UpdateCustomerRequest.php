<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{

    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|unique:customers,email,' . $this->customer->id,
            'phone' => 'nullable|string|max:255',
        ];
    }
}
