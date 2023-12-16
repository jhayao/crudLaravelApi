<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateStudentRequest extends FormRequest
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
     * @return string
     */
    public function rules(): array
    {
        return [
            "student_name" => "string|max:255",
            "student_phone" => "string|max:255",
            "student_address" => "string|max:255",
            "student_image" => "string|max:255",
            "student_email" => [
                "string",
                "email",
                "max:255",
                Rule::unique('students')->ignore($this->id),
            ],
        ];
    }
}
            

          
