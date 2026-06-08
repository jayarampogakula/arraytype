<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $guarded = [];

    protected $casts = [
        'remote' => 'boolean',
        'featured_until' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function poster()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}
