<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UFR extends Model
{
    use HasFactory;
    protected $fillable = ['id_ufr', 'nom'];

    protected $primaryKey='id_ufr';
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'ufr_id', 'id_ufr');
    }

    // Relation avec les listes
    public function listes(): HasMany
    {
        return $this->hasMany(Listes::class, 'ufr_id', 'id_ufr');
    }

    // Relation avec les votes (à vérifier selon votre structure)
    public function votes(): HasMany
    {
        return $this->hasMany(Votes::class, 'ufr_id', 'id_ufr');
    }

    public function currentVote()
    {
        // On suppose qu'une UFR peut avoir plusieurs votes,
        // ici nous récupérons celui dont la date_fin est future
        return $this->hasOne(Votes::class)->where('date_fin', '>', now())->latest('date_debut');
    }
}
