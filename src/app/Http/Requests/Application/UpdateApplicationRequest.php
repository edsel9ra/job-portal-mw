<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Application;

class UpdateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // Solo el reclutador dueño del job puede actualizar el status de la aplicación
    public function authorize(): bool
    {
        $user = $this->user();
        $application = $this->route('application');

        // Solo el reclutador dueño del job puede cambiar el status
        return $user
            && $user->isReclutador()
            && $application
            && $application->job->user_id === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isEntrevista = $this->input('status') === 'Entrevista';
        $isRechazado = $this->input('status') === 'Rechazado';
        return [
            'status' => [
                'required',
                'string',
                Rule::in(Application::STATUSES),
            ],
            // Motivo obligatorio solo cuando se rechaza
            'rejection_reason' => [
                'nullable',
                'string',
                'max:500',
                Rule::requiredIf($isRechazado),
            ],
            // Conteo de entrevistas obligatorio solo cuando se pone en entrevista
            'interview_count' => [
                'nullable',
                'integer',
                'min:1',
                'max:10',
                Rule::requiredIf($isEntrevista),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'rejection_reason.required' => 'El motivo de rechazo es obligatorio al rechazar.',
            'rejection_reason.max' => 'El motivo no puede superar los 500 caracteres.',
            'interview_count.required' => 'Debes indicar cuántas entrevistas se realizarán.',
            'interview_count.min' => 'Debe haber al menos 1 entrevista.',
            'interview_count.max' => 'No puede superar 10 entrevistas.',
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => 'estado',
            'rejection_reason' => 'motivo de rechazo',
            'interview_count' => 'número de entrevistas',
        ];
    }
}
