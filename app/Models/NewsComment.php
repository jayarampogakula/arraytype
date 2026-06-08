<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    protected $guarded = [];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
