<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Etudiant extends Authenticatable
{
    protected $primaryKey = 'id_etudiant'; // ou 'matricule' si c'est votre clé
    // public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'etudiants'; // Vérifiez que c'est le bon nom de votre table

    protected $fillable = ['nom', 'mail', 'mdp','ufr_id']; // Ajoutez les champs nécessaires

    protected $hidden = ['mdp']; // Cache le mot de passe

    public function getAuthPassword()
    {
        return $this->mdp;
    }

    public function ufr()
    {
        return $this->belongsTo(UFR::class);
    }

    public function votes()
    {
        return $this->hasMany(Votes::class);
    }
}
