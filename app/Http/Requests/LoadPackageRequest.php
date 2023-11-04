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
            'load_type_id' => 'required|integer|exists:load_types,id',
            'load_type_type' => 'nullable|string|max:30',
            'deliver_from' => 'nullable|in:address,office',
            'to_office_id' => 'required|integer|',
            'receiver_location' => 'required|string|max:20',
            'distance' => 'required|string|max:20',
            'sender_location' => 'required|string|max:20',
            'sender_name' => 'required|string|max:50',
            'sender_phone' => 'required|string|max:50',
            'sender_street' => 'required|string|max:20',
            'sender_lga' => 'required|integer',
            'sender_apartment' => 'nullable|string|max:50',
            'sender_apartment_no' => 'required|string|max:50',
            'sender_state' => 'required|integer|max:50',
            'sender_email' => 'required|email|max:50',
            'deliver_to' => 'required|in:address,office',
           // 'from_office_id' => 'required|integer',
           'receiver_name' => 'nullable|string|max:50',
           'receiver_phone' => 'nullable|string|max:50',
           'receiver_lga' => 'nullable|integer',
           'receiver_apartment' => 'nullable|string|max:50',
           'receiver_apartment_no' => 'nullable|string|max:50',
           'receiver_street' => 'nullable|string|max:50',
           'receiver_state' => 'nullable|integer|max:50',
           'receiver_email' => 'nullable|email|max:50',
            'is_document' => 'required|in:No,Yes',
            'description' => 'required|string',
            'weight' => 'required|numeric',
            'width' => 'required|numeric',
            'length' => 'required|numeric',
            'height' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'insure_it' => 'nullable|in:No,Yes',
            'insure_amount' => 'nullable|numeric|',
            'is_fragile' => 'nullable|in:No,Yes',
        ];
    }
}
