<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateRequest extends FormRequest
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
            'document_type'   => 'sometimes|required|in:CC,CE,TI,Pasaporte,PT',
            'document_number' => 'sometimes|required|string|max:255',
            'phone'      => 'sometimes|required|string|max:20',
            'city'       => 'sometimes|required|string|max:100',
            'birth_date' => 'sometimes|required|date|before:today',
            'photo'      => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
