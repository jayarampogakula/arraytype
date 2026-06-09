<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'is_premium',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_premium' => 'boolean',
        ];
    }

    public function isPremium(): bool
    {
        return (bool) $this->is_premium;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'created_by');
    }

    public function memberships()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function tools()
    {
        return $this->hasMany(Tool::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productVotes()
    {
        return $this->hasMany(ProductVote::class);
    }

    public function productComments()
    {
        return $this->hasMany(ProductComment::class);
    }

    public function newsComments()
    {
        return $this->hasMany(NewsComment::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }

    public function connectedTo()
    {
        return $this->hasMany(Connection::class, 'connected_user_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
