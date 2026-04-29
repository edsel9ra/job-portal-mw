<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property-read int|null $age
 */

class Candidate extends Model
{
    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'phone',
        'birth_date',
        'city',
        'photo',
    ];

    public const PAGINATE = 10;

    protected $casts = [
        'birth_date' => 'date',
    ];

    // ── Relaciones ──────────────────────────────────────────────
    /**
     * Usuario al que pertenece este perfil de candidato.
     * Relación inversa 1-a-1.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Postulaciones enviadas por este candidato.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Curriculum del candidato. Relación 1-a-1.
     */

    public function resume()
    {
        return $this->hasOne(Resume::class);
    }

    // ── Helpers ─────────────────────────────────────────────────
    /**
     * Obtener la edad del candidato a partir de su fecha de nacimiento.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    /**
     * URL pública de la foto de perfil o null si no tiene.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo
            ? asset("storage/{$this->photo}")
            : null;
    }

    public function hasPhoto(): bool
    {
        return $this->photo !== null;
    }
}
