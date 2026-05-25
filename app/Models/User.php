<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'full_name',
        'photo',
        'city',
        'general_level',
        'bio',
        'age',
        'has_band',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class)->withPivot('level');
    }

    public function bandHistories()
    {
        return $this->hasMany(BandHistory::class);
    }

    public function following()
{
    return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
                ->withPivot('status')
                ->withTimestamps();
}

public function followers()
{
    return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
                ->withPivot('status')
                ->withTimestamps();
}

// Helpers útiles
public function isFollowing(User $user): bool
{
    return $this->following()->where('following_id', $user->id)->exists();
}

public function followStatus(User $user): ?string
{
    $follow = $this->following()->where('following_id', $user->id)->first();
    return $follow ? $follow->pivot->status : null;
}
}