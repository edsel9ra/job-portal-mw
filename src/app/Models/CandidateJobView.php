<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateJobView extends Model
{
    protected $fillable = [
        'candidate_id',
        'job_id',
        'views_count',
        'last_seen_at',
    ];
}
