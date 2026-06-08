<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function connectedUser()
    {
        return $this->belongsTo(User::class, 'connected_user_id');
    }
}
