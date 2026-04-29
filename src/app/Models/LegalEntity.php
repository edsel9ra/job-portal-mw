<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalEntity extends Model
{
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function branches() {
        return $this->hasMany(Branch::class);
    }
}
