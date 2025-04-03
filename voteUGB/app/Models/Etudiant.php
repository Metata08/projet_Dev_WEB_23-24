<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Etudiant extends Authenticatable
{
    protected $primaryKey = 'id_etudiant'; // ou 'matricule' si c'est votre clé
    // public $incrementing = false;
    protected $keyType = 'string';

    public $incrementing = true; // Doit être true pour auto-incrémenter
    protected $table = 'etudiants'; // Vérifiez que c'est le bon nom de votre table
    protected $fillable = [
        'nom',
        'prenom',
        'code_etudiant',
        'mail',
        'ufr_id',
        'mdp',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Renommage du champ mot de passe pour l'authentification
    public function getAuthPassword()
    {
        return $this->mdp;
    }

    // Relations
    public function ufr()
    {
        return $this->belongsTo(Ufr::class, 'ufr_id', 'id_ufr');
    }

    public function votes()
    {
        return $this->hasMany(Votes::class, 'etudiant_id');
    }

    // Accesseur pour le nom complet
    public function getNomCompletAttribute()
    {
        return $this->prenom.' '.$this->nom;
    }
}