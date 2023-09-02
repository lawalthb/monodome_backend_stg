<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadBoardRequest extends FormRequest
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
            // 'user_id' => 'required|integer',
            // 'load_type_id' => 'required|integer',
            // 'load_type_name' => 'nullable|string|max:30',
            'status' => 'required|in:Pending,Failed,Completed,Rejected',
            // 'order_no' => 'required|string',
            // 'loadable_id' => 'required|integer',
            // 'loadable_type' => 'required|string',
        ];
    }
}
