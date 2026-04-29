<?php

namespace App\Http\Requests\Resume;

use Illuminate\Foundation\Http\FormRequest;

class CreateResumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Solo candidatos que aún no tienen resume
        $user = $this->user();

        return $user
            && $user->isCandidato()
            && $user->candidate
            && !$user->candidate->resume;
    }

    protected function prepareForValidation(): void
    {
        // Si el frontend envía arrays como string JSON (típico con multipart/form-data + file)
        foreach (['work_experience', 'education', 'skills', 'certifications', 'languages'] as $field) {
            $value = $this->input($field);

            if (is_string($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $this->merge([$field => $decoded]);
                }
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $maxYear = now()->year + 1;

        return [
            'summary' => ['required', 'string', 'max:1000'], // o max:1000 si migras summary a text

            'work_experience' => ['nullable', 'array', 'list'],
            'work_experience.*.company' => ['required', 'string', 'max:150'],
            'work_experience.*.position' => ['required', 'string', 'max:150'],
            'work_experience.*.start_date' => ['required', 'date'],
            'work_experience.*.end_date' => ['nullable', 'date'],
            'work_experience.*.description' => ['nullable', 'string', 'max:1000'],

            'education' => ['nullable', 'array', 'list'],
            'education.*.title' => ['required', 'string', 'max:150'],
            'education.*.school' => ['required', 'string', 'max:150'],
            'education.*.year' => ['required', 'integer', 'min:1950', "max:$maxYear"],

            'skills' => ['nullable', 'array', 'list'],
            'skills.*' => ['string', 'max:80', 'distinct:ignore_case'],

            'certifications' => ['nullable', 'array', 'list'],
            'certifications.*.name' => ['required', 'string', 'max:150'],
            'certifications.*.institution' => ['nullable', 'string', 'max:150'],
            'certifications.*.year' => ['nullable', 'integer', 'min:1950', "max:$maxYear"],

            'languages' => ['nullable', 'array', 'list'],
            'languages.*.name' => ['required', 'string', 'max:80'],
            'languages.*.level' => ['required', 'string', 'in:Básico,Intermedio,Avanzado,Nativo'],

            // ✅ archivo real
            'pdf_file' => ['nullable', 'file', 'mimetypes:application/pdf', 'max:5120'],
        ];
    }

    public function withValidator($validator): void
    {
        // Validación extra: end_date >= start_date por cada item
        $validator->after(function ($validator) {
            $items = $this->input('work_experience', []);

            if (!is_array($items))
                return;

            foreach ($items as $i => $item) {
                $start = $item['start_date'] ?? null;
                $end = $item['end_date'] ?? null;

                if ($start && $end && strtotime($end) < strtotime($start)) {
                    $validator->errors()->add(
                        "work_experience.$i.end_date",
                        'La fecha de finalización debe ser posterior o igual a la fecha de inicio.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'summary.required' => 'El resumen profesional es obligatorio.',
            'pdf_file.mimetypes' => 'El archivo debe ser un PDF válido.',
            'pdf_file.max' => 'El PDF no debe superar los 5 MB.',
            'languages.*.level.in' => 'El nivel del idioma no es válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'summary' => 'resumen profesional',
            'work_experience.*.company' => 'empresa',
            'work_experience.*.position' => 'cargo',
            'work_experience.*.start_date' => 'fecha de inicio',
            'work_experience.*.end_date' => 'fecha de finalización',
            'pdf_file' => 'hoja de vida en PDF',
        ];
    }
}
