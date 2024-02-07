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
            'load_type_id' => 'required|integer|exists:load_types,id|in:1',
            'load_type_type' => 'nullable|string|max:30',
            'deliver_from' => 'nullable|in:address,office,map',
            'to_office_id' => 'sometimes|required_if:deliver_to,office|nullable|integer',
            'receiver_location' => 'required|string',
            'distance' => 'nullable|string',
            'sender_location' => 'nullable|string',
            'sender_name' => 'nullable|string|max:50',
            'sender_phone' => 'nullable|string|max:50',
            'sender_street' => 'nullable|string|max:20',
            'sender_lga' => 'nullable|integer',
            'sender_apartment' => 'nullable|string|max:50',
            'sender_apartment_no' => 'nullable|string|max:50',
            'sender_state' => 'nullable|integer|max:50',
            'sender_email' => 'nullable|email|max:50',
            'deliver_to' => 'nullable|in:address,office,map',
            'from_office_id' => 'sometimes|required_if:deliver_from,office|nullable|integer',
           'receiver_name' => 'nullable|string|max:50',
           'receiver_phone' => 'nullable|string|max:50',
           'receiver_lga' => 'nullable|integer',
           'receiver_apartment' => 'nullable|string|max:50',
           'receiver_apartment_no' => 'nullable|string|max:50',
           'receiver_street' => 'nullable|string|max:50',
           'receiver_state' => 'nullable|integer|max:50',
           'receiver_email' => 'nullable|email|max:50',
            'is_document' => 'required|in:No,Yes',
            'description' => 'nullable|string',
            'weight' => 'required_if:is_document,No',
            'width' => 'nullable',
            'length' => 'nullable',
            'height' => 'nullable',
            'total_amount' => 'required|numeric',
            'insure_it' => 'nullable|in:No,Yes',
            'insure_amount' => 'nullable|numeric|',
            'is_fragile' => 'nullable|in:No,Yes',
          //  'documents.*' => 'required|file|max:2048'
        ];
    }
}
