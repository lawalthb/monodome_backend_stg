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
            'load_type_id' => 'required|integer',
            'load_type_type' => 'nullable|string|max:30',
            'deliver_from' => 'nullable|in:address,office',
            'to_office_id' => 'required|integer|',
            'sender_name' => 'required|string|max:30',
            'sender_phone' => 'required|string|max:30',
            'sender_zip_code' => 'required|string|max:20',
            'sender_city' => 'required|string|max:30',
            'sender_street' => 'required|string|max:30',
            'state_id' => 'required|string|max:30',
            'sender_email' => 'required|string|max:30|email',
            'deliver_to' => 'required|in:address,office',
           // 'from_office_id' => 'required|integer',
            'receiver_name' => 'required|string|max:30',
            'receiver_phone' => 'required|string|max:30',
            'receiver_zip_code' => 'required|string|max:30',
            'receiver_city' => 'required|string|max:30',
            'receiver_street' => 'required|string|max:30',
            'receiver_number' => 'required|string|max:30',
            'receiver_email' => 'required|string|max:30|email',
            'is_document' => 'required|in:No,Yes',
            'description' => 'required|string',
            'weight' => 'required|numeric',
            'width' => 'required|numeric',
            'length' => 'required|numeric',
            'height' => 'required|numeric',
            'insure_it' => 'nullable|in:No,Yes',
            'insure_amount' => 'nullable|numeric|',
            'is_fragile' => 'nullable|in:No,Yes',
        ];
    }
}
