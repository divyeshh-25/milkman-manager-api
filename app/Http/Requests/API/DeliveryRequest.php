<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'customer_id' => 'required|exists:users,id',
                    'milk_type_id' => 'required|exists:milk_types,id',
                    'date' => 'required|date',
                    'delivered_qty' => 'required|numeric',
                    'change_qty' => 'numeric',
                    'notes' => 'nullable|string'
                ];
                break;
            case 'PUT':
                return [
                    'customer_id' => 'sometimes|required|exists:users,id',
                    'milk_type_id' => 'sometimes|required|exists:milk_types,id',
                    'date' => 'sometimes|required|date',
                    'delivered_qty' => 'sometimes|required|numeric',
                    'change_qty' => 'sometimes|numeric',
                    'notes' => 'nullable|string'
                ];
                break;
        }
    }
}
