<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'nip' => ['required', 'unique:teachers,nip'],
            'name' => ['required', 'max:255'],
            'gender' => ['required', 'in:male,female'],
            'birth_place' => ['required', 'max:255'],
            'birth_date' => ['required', 'date_format:Y-m-d'],
            'phone_number' => ['required'],
        ];
    }
}
