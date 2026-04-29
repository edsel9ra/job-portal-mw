<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function legalEntity() {
        return $this->belongsTo(LegalEntity::class);
    }

    public function jobs() {
        return $this->hasMany(Job::class);
    }
}
