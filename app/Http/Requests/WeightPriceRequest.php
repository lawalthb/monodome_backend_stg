<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightPriceRequest extends FormRequest
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
            'min_weight' => 'required|numeric|min:0',
            'max_weight' => 'required|numeric|min:' . $this->input('min_weight'),
            'load_type_id' => 'required|exists:load_types,id|in:1,2,6',
            'price' => 'required|integer|min:0',
            'vehicle_description' => 'nullable',
            'status' => 'nullable|in:Active,inActive'
        ];
    }
}
