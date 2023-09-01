<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadPackageRequest extends FormRequest
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
            'load_board_id' => 'required|integer',
            'deliver_from' => 'nullable|in:address,office',
            'to_office_id' => 'nullable|integer|default:1',
            'sender_name' => 'nullable|string|max:30',
            'sender_phone' => 'nullable|string|max:30',
            'sender_zipcode' => 'nullable|string|max:20',
            'sender_city' => 'nullable|string|max:30',
            'sender_street' => 'nullable|string|max:30',
            'state_id' => 'nullable|string|max:30',
            'sender_email' => 'nullable|string|max:30|email',
            'deliver_to' => 'nullable|in:address,office',
            'from_office_id' => 'nullable|integer|default:1',
            'receiver_name' => 'nullable|string|max:30',
            'receiver_phone' => 'nullable|string|max:30',
            'receiver_zipcode' => 'nullable|string|max:30',
            'receiver_city' => 'nullable|string|max:30',
            'receiver_street' => 'nullable|string|max:30',
            'receiver_number' => 'nullable|string|max:30',
            'receiver_email' => 'nullable|string|max:30|email',
            'is_document' => 'required|in:No,Yes',
            'description' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'insure_it' => 'nullable|in:No,Yes',
            'insure_amount' => 'nullable|numeric|default:0',
            'is_fragile' => 'nullable|in:No,Yes',
        ];
    }
}
