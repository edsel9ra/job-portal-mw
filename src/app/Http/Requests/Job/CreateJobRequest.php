<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
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
            'name_job' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|numeric',
            'status' => 'required|in:Abierta,Pausada,Cerrada',
            'contract_type' => 'required|in:Término Fijo,Término Indefinido,Obra o Labor,Aprendizaje,Ocasional,Prestación de Servicios',
            'branch_id' => 'required|exists:branches,id',
        ];
    }
}
