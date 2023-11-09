<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoadBulkRequest extends FormRequest
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
            'deliver_from' => 'nullable|in:address,office',
            'to_office_id' => 'required_if:deliver_to,office|nullable|integer', // Make it required if 'deliver_to' is 'office'
            'sender_name' => 'required|string|max:50',
            'sender_phone' => 'required|string|max:50',
            'sender_street' => 'required|string|max:20',
            'receiver_location' => 'required|string',
            'distance' => 'required|string',
            'sender_location' => 'required|string',
            'sender_lga' => 'required|integer',
            'sender_apartment' => 'nullable|string|max:50',
            'sender_apartment_no' => 'nullable|string|max:50',
            'sender_state' => 'required|integer',
            'sender_email' => 'required|email|max:50',
            'deliver_to' => 'nullable|in:address,office',
            'receiver_name' => 'nullable|string|max:50',
            'receiver_phone' => 'nullable|string|max:50',
            'receiver_lga' => 'nullable|integer',
            'receiver_apartment' => 'nullable|string|max:50',
            'receiver_apartment_no' => 'nullable|string|max:50',
            'receiver_street' => 'nullable|string|max:50',
            'receiver_state' => 'nullable|integer',
            'receiver_email' => 'nullable|email|max:50',
            'is_schedule' => 'required|in:No,Yes',
            'description' => 'required|string',
            'vehicle_no' => 'required|string|max:50',
            'schedule_date' => 'nullable',
            'weight' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'insure_it' => 'nullable|in:Yes,No',
            'total_amount' => 'required|numeric',
            'insure_amount' => 'nullable|numeric',
            'is_fragile' => 'nullable|in:Yes,No',
         //   'documents' => 'required|array',
           // 'documents.*' => 'nullable|string|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
}
