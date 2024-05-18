<?php

namespace App\Http\Requests\Medication;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:medications,name,'. $this->medication->name. ',name',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:1',
        ];
    }
}
