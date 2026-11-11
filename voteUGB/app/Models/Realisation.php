<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Realisation extends Model
{
    protected $fillable = ['list_id', 'annee', 'titre', 'description'];
}
