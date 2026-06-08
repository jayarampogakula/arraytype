<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'launch_date' => 'date',
        'featured_until' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function votes()
    {
        return $this->hasMany(ProductVote::class);
    }

    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }
}
