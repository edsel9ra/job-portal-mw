<?php

namespace App\Models;

use \App\Models\Branch;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    protected $fillable = ['name_job', 'description', 'salary', 'status', 'contract_type', 'branch_id', 'user_id'];
    public const PAGINATE = 10;

    //pendiente de revisar esta relación, no se si es hasMany o belongsToMany
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
