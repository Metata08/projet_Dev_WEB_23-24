<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Etudiant extends Authenticatable
{
    protected $table = 'etudiants';

    protected $primaryKey = 'id_etudiant';

    protected $fillable = ['nom', 'prenom', 'code_etudiant', 'email', 'ufr_id', 'mdp'];

    protected $hidden = ['mdp'];

    /** Le mot de passe est stocké dans la colonne « mdp ». */
    public function getAuthPasswordName()
    {
        return 'mdp';
    }

    public function getAuthPassword()
    {
        return $this->mdp;
    }

    /** La table ne possède pas de colonne remember_token. */
    public function getRememberTokenName()
    {
        return '';
    }

    public function ufr()
    {
        return $this->belongsTo(UFR::class, 'ufr_id', 'id_ufr');
    }

    public function bulletins()
    {
        return $this->hasMany(VoteEtudiant::class, 'etudiant_id', 'id_etudiant');
    }

    /** Bulletin déposé par l'étudiant pour un scrutin donné (ou null). */
    public function bulletinPour(?Votes $scrutin): ?VoteEtudiant
    {
        if (! $scrutin) {
            return null;
        }

        return $this->bulletins()->where('vote_id', $scrutin->id_vote)->first();
    }

    public function getNomCompletAttribute(): string
    {
        return ucfirst($this->prenom).' '.mb_strtoupper($this->nom);
    }

    public function getInitialesAttribute(): string
    {
        return mb_strtoupper(mb_substr($this->prenom, 0, 1).mb_substr($this->nom, 0, 1));
    }
}
