<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Etudiant extends Authenticatable
{
    use Notifiable;

    protected $table = 'etudiants';
    protected $primaryKey = 'id_etudiant';
    
    protected $fillable = ['nom', 'prenom', 'email', 'mdp', 'ufr_id'];

    protected $hidden = ['mdp', 'remember_token'];

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
        return $this->hasMany(Vote::class, 'etudiant_id');
    }

    // Accesseur pour le nom complet
    public function getNomCompletAttribute()
    {
        return $this->prenom.' '.$this->nom;
    }
}