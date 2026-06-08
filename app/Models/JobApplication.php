<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $guarded = [];

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
