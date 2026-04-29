<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'candidate_id',
        'summary',
        'work_experience',
        'education',
        'skills',
        'certifications',
        'languages',
        'pdf_path',
        'pdf_mime',
        'pdf_size',
    ];

    public const PAGINATE = 10;
    protected $appends = ['pdf_url'];

    /**
     * Work_experience, education, skills, certifications y languages se guardan como JSON en la BD.
     * Laravel los serializa/deserializa automáticamente como arrays.
     *
     * Estructura esperada de education:
     * [
     *   { "title": "Ingeniería de Sistemas", "school": "U. Nacional", "year": 2020 },
     * ]
     *
     * Estructura esperada de experience:
     * [
     *   { "company": "Acme", "position": "Dev", "start_date": "2021-01-01", "end_date": null },
     * ]
     */
    protected $casts = [
        'work_experience' => 'array',
        'education' => 'array',
        'skills' => 'array',
        'certifications' => 'array',
        'languages' => 'array',
    ];

    // ── Relaciones ──────────────────────────────────────────────
    /**
     * Candidato al que pertenece este curriculum. Relación inversa 1-a-1.
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // ── Helpers ─────────────────────────────────────────────────
    /**
     * Devuelve la URL pública del PDF del CV, o null si no tiene.
     */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_path ? asset("storage/{$this->pdf_path}") : null;
    }

    /**
     * Indica si el curriculum tiene PDF subido.
     */
    public function hasPdf(): bool
    {
        return !empty($this->pdf_path);
    }
}
