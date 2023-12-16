<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            "student_name" => ["required", "string", "max:255"],
            "student_email" => ["required", "string", "email", "max:255", "unique:students"],
            "student_phone" => ["required", "string", "max:255"],
            "student_address" => ["required", "string", "max:255"],
            // "student_image" => ["required", "string", "max:255"],
        ];
    }
}
