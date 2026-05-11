<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BandHistory extends Model
{
    protected $fillable = ['user_id', 'band_name', 'role', 'year_start', 'year_end'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}