<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($group) {
            if (empty($group->slug)) {
                $group->slug = \Illuminate\Support\Str::slug($group->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', strtolower($value))->firstOrFail();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
