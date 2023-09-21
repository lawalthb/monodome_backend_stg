<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:credit,debit',
            'card_number' => 'required|string|max:255',
            'cvv' => 'nullable|string|max:200',
            'name_on_card' => 'nullable|string|max:255',
            'expiry_month' => 'required|string|max:200',
            'expiry_year' => 'required|string|max:200',
            'amount' => 'required|numeric',
            'card_id' => 'nullable|numeric',
        ];
    }
}
