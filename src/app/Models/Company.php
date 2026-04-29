<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function legalEntities() {
        return $this->hasMany(LegalEntity::class);
    }

    // Magia de Laravel: Acceder a todas las sedes de todas las razones sociales de la empresa
    public function branches() {
        return $this->hasManyThrough(Branch::class, LegalEntity::class);
    }
}
