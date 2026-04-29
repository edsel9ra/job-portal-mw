<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class CreateCandidateRequest extends FormRequest
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
            'user' => 'required|exists:users,id|unique:candidates,user_id',
            'document_type' => 'required|in:CC,CE,TI,Pasaporte,PT',
            'document_number' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'city' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Opcional, debe ser una imagen y no superar los 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'candidate_id.unique' => 'El ID del candidato ya está en uso.',
            'document_type.required' => 'El tipo de documento es obligatorio.',
            'document_type.in' => 'El tipo de documento debe ser CC, CE, TI, Pasaporte o PT.',
            'document_number.required' => 'El número de documento es obligatorio.',
            'birth_date.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            'photo.image' => 'La foto debe ser una imagen válida.',
            'photo.max' => 'La foto no debe superar los 2MB.',
            'photo.mimes' => 'La foto debe ser un archivo de tipo: jpeg, png, webp.',
        ];
    }
}