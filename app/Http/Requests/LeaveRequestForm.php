<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestForm extends FormRequest
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
        'leave_type_setting_id'=> 'required|integer',
        'relief_id'=> 'required|integer',
        'reason'=>"nullable",
        'fromDate' =>"required|date|after_or_equal:today",
        'toDate' =>"required|date|after_or_equal:fromDate",
        'leave_option'=>"required",
        ];
    }

    public function messages()
    {
        return [
            'fromDate.required' => 'The leave date is required.',
            'fromDate.date' => 'The leave date must be a valid date format.',
            'fromDate.after_or_equal' => 'The start date cannot be in the past.',
            'toDate.after_or_equal' => 'The end date must be after or the same as the start date.',
        ];
    }

}
