<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UFR extends Model
{
    use HasFactory;
    protected $fillable = ['id_ufr', 'nom'];

    protected $primaryKey='id_ufr';
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

    public function currentVote()
    {
        // On suppose qu'une UFR peut avoir plusieurs votes,
        // ici nous récupérons celui dont la date_fin est future
        return $this->hasOne(Votes::class)->where('date_fin', '>', now())->latest('date_debut');
    }
}
