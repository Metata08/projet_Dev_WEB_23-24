<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UFR extends Model
{
    use HasFactory;
    protected $fillable = ['id_ufr', 'nom'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function listes()
    {
        return $this->hasMany(Listes::class);
    }


    public function vote(): BelongsTo
    {
        return $this->belongsTo(Votes::class);
    }
}

