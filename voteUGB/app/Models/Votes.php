<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Votes extends Model
{
    use HasFactory;
    protected $fillable = ['id_vote', 'date_debut', 'date_fin'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function ufrs(): HasMany
    {
        return $this->hasMany(UFR::class);
    }
}

