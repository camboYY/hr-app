<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveUpdateRequestForm extends FormRequest
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
        'leave_type_setting_id'=> 'nullable|integer',
        'relief_id'=> 'nullable|integer',
        'reason'=>"nullable",
        'fromDate' =>"nullable|date|after_or_equal:today",
        'toDate' =>"nullable|date|after_or_equal:fromDate",
        'leave_option'=>"required",
        ];
    }
}
