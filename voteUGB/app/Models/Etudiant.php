<?php

namespace App\Models;

use App\Notifications\ReinitialiserMotDePasse;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Etudiant extends Authenticatable
{
    use Notifiable;

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

    public function emargements()
    {
        return $this->hasMany(Emargement::class, 'etudiant_id', 'id_etudiant');
    }

    /** Émargement de l'étudiant pour un scrutin donné (ou null s'il n'a pas voté). */
    public function emargementPour(?Votes $scrutin): ?Emargement
    {
        if (! $scrutin) {
            return null;
        }

        return $this->emargements()->where('vote_id', $scrutin->id_vote)->first();
    }

    /** Liste dont l'étudiant est tête de liste (ou null). */
    public function listeDirigee(): ?Listes
    {
        return Listes::whereHas('membres', fn ($q) => $q->where('id_membre', $this->id_etudiant)->where('tete_liste', true))
            ->orderBy('id_list')
            ->first();
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ReinitialiserMotDePasse($token));
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
