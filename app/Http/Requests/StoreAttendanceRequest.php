<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'student_id' => 'required|integer|exists:students,id|unique:attendances,student_id,NULL,id,event_id,' . $this->input('event_id'),
            'attendance_status' => 'string|max:255',
            'attendace_date' => 'datetime',
            'event_id' => 'required|integer|exists:events,id',
        ];
    }

    public function messages()
{
    return [
        'student_id.unique' => 'You have already join this event',
    ];
}
}
