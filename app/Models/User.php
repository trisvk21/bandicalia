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
}