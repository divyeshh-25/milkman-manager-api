<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'       => 'required|string|max:255',
                    'email'      => 'nullable|email|unique:users,email',
                    'phone'      => 'nullable|string|max:20',
                    'flat_no'    => 'nullable|string',
                    'status'     => 'nullable|boolean',
                    'milk_types' => 'nullable|array',
                ];
                break;
            case 'PUT':
                return [
                    'name'       => 'sometimes|string|max:255',
                    'email'      => 'nullable|email|unique:users,email,' . $this->user->id,
                    'phone'      => 'nullable|string|max:20',
                    'flat_no'    => 'nullable|string',
                    'status'     => 'nullable|boolean',
                    'milk_types' => 'nullable|array',
                ];
                break;
        }
    }
}
