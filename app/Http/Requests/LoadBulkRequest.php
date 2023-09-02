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
            'to_office_id' => 'nullable|integer',
            'sender_name' => 'nullable|string|max:30',
            'sender_phone' => 'nullable|string|max:30',
            'sender_zip_code' => 'nullable|string|max:20',
            'sender_city' => 'nullable|string|max:30',
            'sender_state_id' => 'nullable|string|max:30',
            'sender_number' => 'nullable|string|max:30',
            'sender_email' => 'nullable|email|max:30',
            'deliver_to' => 'nullable|in:address,office',
           // 'from_office_id' => 'nullable|integer',
            'receiver_name' => 'nullable|string|max:30',
            'receiver_phone' => 'nullable|string|max:30',
            'receiver_zip_code' => 'nullable|string|max:30',
            'receiver_city' => 'nullable|string|max:30',
            'receiver_state_id' => 'nullable|string|max:30',
           // 'receiver_number' => 'nullable|string|max:30',
            'receiver_email' => 'nullable|email|max:30',
            'is_schedule' => 'nullable|in:No,Yes',
            'description' => 'nullable|string',
            'vehicle_no' => 'nullable|string|max:30',
            'weight' => 'nullable|numeric',
            'schedule_date' => 'nullable|date',
            //'document' => 'nullable|integer',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'insure_it' => 'nullable|in:Yes,No',
            'insure_amount' => 'nullable|numeric',
            'is_fragile' => 'nullable|in:Yes,No',
            //'documents' => 'array', // An array of uploaded files
            //'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
}
