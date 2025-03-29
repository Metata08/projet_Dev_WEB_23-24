<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Etudiant extends Authenticatable
{
    use Notifiable;

    protected $table = 'etudiants'; // Si le nom de la table est différent de "etudiants"
    
    protected $fillable = [
        'mail',
        'mdp',
    ];

    protected $hidden = [
        'mdp',
    ];
    use HasFactory;
    // protected $fillable = ['id_etudiant', 'nom', 'prenom', 'code_etudiant', 'mail', 'mdp', 'ufr_id'];

    public function ufr()
    {
        return $this->belongsTo(UFR::class);
    }

    public function votes()
    {
        return $this->hasMany(Votes::class);
    }
}

