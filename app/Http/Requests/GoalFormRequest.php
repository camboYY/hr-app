<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalFormRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'required|string|max:255',
            'comment' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,pending,completed,progessing',
            'category_id' => 'required|integer',
            'weight' => 'required|integer',
            'meet_target_amount'=>'nullable|integer',
            'exceed_target_amount'=>'nullable|integer',
            'significant_exceed_target_amount'=>'nullable|integer',
            'actual_archievement_amount'=>'nullable|integer',
            'reviewed_by'=> 'nullable|integer',
            'track_by'=> 'required|string',
            'complete_date'=> 'nullable|date',
            'assigned_date'=> 'nullable|date',
            'progress' => 'nullable|integer',
        ];
    }
}
