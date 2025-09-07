<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class MilkTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        switch($this->method()){
            case 'POST':
                return [
                    'name' => 'required|string|unique:milk_types,name',
                    'default_rate' => 'numeric'
                ];
                break;
            case 'PUT':
                return [
                    'name' => 'required|string|unique:milk_types,name,'.$this->milk_type->id,
                    'default_rate' => 'numeric'
                ];
                break;
        }
    }
}
