<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadContainerShipmentRequest extends FormRequest
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
            'departure_country' => 'required|integer',
            'destination_country' => 'required|integer',
            'container_height' => 'required|string',
            'container_carrier_id' => 'required|integer',
            'container_value' => 'required|string',
            'cars_in_container' => 'required',
            'other_contents_in_container' => 'required',
            // 'documents' => 'required|array',
            // '*.documents' => 'required|string',
            'content_description' => 'nullable|string',
            'is_final' => 'required|in:Yes,No',
            'deliver_from_city' => 'required_if:is_final,Yes|integer',
            'deliver_to_city' => 'required_if:is_final,Yes|integer',
            'receiver_name' => 'required_if:is_final,Yes|string|max:30',
           // 'deliver_apartment' => 'required_if:is_final,Yes|string|max:30',
            'receiver_email' => 'required_if:is_final,Yes|email',
            'receiver_phone' => 'required_if:is_final,Yes|string|max:30',
          //  'zip_code' => 'required|string|max:30',
            'street' => 'required_if:is_final,Yes|string|max:30',
            'add_info' => 'nullable|string',
            'insure_it' => 'nullable|in:Yes,No',
            'suggested_amount' => 'nullable|integer',
            'total_amount' => 'nullable|numeric',
            'status' => 'nullable|in:Pending,Approved,Failed',
        ];
    }
}
