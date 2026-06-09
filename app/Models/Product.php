<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'launch_date' => 'date',
        'featured_until' => 'datetime',
        'pinned_until' => 'datetime',
    ];

    public function isPinnedHomepage(): bool
    {
        return $this->is_pinned || ($this->pin_type === 'homepage' && $this->pinned_until && $this->pinned_until->isFuture());
    }

    public function isPinnedCategory(): bool
    {
        return $this->pin_type === 'category' && $this->pinned_until && $this->pinned_until->isFuture();
    }

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
