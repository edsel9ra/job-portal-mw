<?php

namespace App\Http\Requests\Resume;

use Illuminate\Foundation\Http\FormRequest;


class UpdateResumeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $resume = $this->route('resume'); // route model binding

        return $user
            && $user->isCandidato()
            && $user->candidate
            && $resume
            && (int) $resume->candidate_id === (int) $user->candidate->id;
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

    public function rules(): array
    {
        $maxYear = now()->year + 1;

        return [
            // En update: si se envía, debe ser válido. Si no se envía, no obliga.
            'summary' => ['sometimes', 'required', 'string', 'max:1000'],

            'work_experience' => ['sometimes', 'nullable', 'array', 'list'],
            'work_experience.*.company' => ['required', 'string', 'max:150'],
            'work_experience.*.position' => ['required', 'string', 'max:150'],
            'work_experience.*.start_date' => ['required', 'date'],
            'work_experience.*.end_date' => ['nullable', 'date'],
            'work_experience.*.description' => ['nullable', 'string', 'max:1000'],

            'education' => ['sometimes', 'nullable', 'array', 'list'],
            'education.*.title' => ['required', 'string', 'max:150'],
            'education.*.school' => ['required', 'string', 'max:150'],
            'education.*.year' => ['required', 'integer', 'min:1950', "max:$maxYear"],

            'skills' => ['sometimes', 'nullable', 'array', 'list'],
            'skills.*' => ['string', 'max:80', 'distinct:ignore_case'],

            'certifications' => ['sometimes', 'nullable', 'array', 'list'],
            'certifications.*.name' => ['required', 'string', 'max:150'],
            'certifications.*.institution' => ['nullable', 'string', 'max:150'],
            'certifications.*.year' => ['nullable', 'integer', 'min:1950', "max:$maxYear"],

            'languages' => ['sometimes', 'nullable', 'array', 'list'],
            'languages.*.name' => ['required', 'string', 'max:80'],
            'languages.*.level' => ['required', 'string', 'in:Básico,Intermedio,Avanzado,Nativo'],

            // PDF opcional (archivo real)
            'pdf_file' => ['sometimes', 'nullable', 'file', 'mimetypes:application/pdf', 'max:5120'],
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
}
