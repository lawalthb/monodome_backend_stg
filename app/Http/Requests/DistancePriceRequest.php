<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistancePriceRequest extends FormRequest
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
        return [
            'min_km' => 'required|numeric|min:0',
            'max_km' => 'required|numeric|min:' . $this->input('min_km'),
            'load_type_id' => 'required|exists:load_types,id',
            'price' => 'required|integer|min:0',
        ];
    }
}
