<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Job;
use App\Models\Application;

class CreateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $candidate = $user?->candidate;

        // Solo candidatos con curriculum creado pueden aplicar
        return $user
            && $user->isCandidato()
            && $candidate
            && $candidate->resume()->exists();
    }

    // Prepara el request antes de la validación
    protected function prepareForValidation(): void
    {
        // job_id puede venir como route param en lugar de body
        if (!$this->has('job_id') && $this->route('job')) {
            $this->merge(['job_id' => $this->route('job')->id]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'job_id' => ['required', 'integer', 'exists:jobs,id'],
            'cover_letter' => ['nullable', 'string', 'max:2000'],
        ];
    }

    // Validación adicional después de las reglas básicas
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $candidate = $this->user()->candidate;
            $jobId = (int) $this->input('job_id');
            $job = Job::find($jobId);

            if ($job && $job->status !== 'Abierta') {
                $validator->errors()->add(
                    'job_id',
                    'Esta oferta no está disponible para aplicaciones.'
                );
            }

            $yaAplico = Application::where('candidate_id', $candidate->id)
                ->where('job_id', $jobId)
                ->exists();

            if ($yaAplico) {
                $validator->errors()->add('job_id', 'Ya has aplicado a esta oferta.');
            }
        });
    }

    // Personaliza los mensajes de error
    public function messages(): array
    {
        return [
            'job_id.required' => 'La oferta es obligatoria.',
            'job_id.exists' => 'La oferta seleccionada no existe.',
            'cover_letter.max' => 'La carta de presentación no puede superar los 2000 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'job_id' => 'oferta',
            'cover_letter' => 'carta de presentación',
        ];
    }
}
