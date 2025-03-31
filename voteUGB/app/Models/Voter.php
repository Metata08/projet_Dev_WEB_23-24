<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Voter extends Authenticatable
{
    protected $fillable = ['firstname', 'lastname', 'email', 'password'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}