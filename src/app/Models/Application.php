<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'job_id',
        'candidate_id',
        'cover_letter',
        'status',
        'applied_at',
        'reviewed_at',
        'rejection_reason',
        'interview_count',
    ];

    public const PAGINATE = 10;

    // Define relationships
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Define status constants
    public const STATUSES = ['Aplicado', 'En Revisión', 'Entrevista', 'Rechazado', 'Contratado'];

    protected $attributes = [
        'status' => 'Aplicado',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'interview_count' => 'integer',
    ];

    // ── Scopes ──────────────────────────────────────────────────
    public function scopeAplicado($query)   { return $query->where('status', 'Aplicado'); }
    public function scopeEnRevision($query) { return $query->where('status', 'En Revisión'); }
    public function scopeEntrevista($query) { return $query->where('status', 'Entrevista'); }
    public function scopeRechazado($query)  { return $query->where('status', 'Rechazado'); }
    public function scopeContratado($query) { return $query->where('status', 'Contratado'); }

    // ── Helpers ──────────────────────────────────────────────────
    public function isAplicado()   { return $this->status === 'Aplicado'; }
    public function isEnRevision() { return $this->status === 'En Revisión'; }
    public function isEntrevista() { return $this->status === 'Entrevista'; }
    public function isRechazado()  { return $this->status === 'Rechazado'; }
    public function isContratado() { return $this->status === 'Contratado'; }
}
