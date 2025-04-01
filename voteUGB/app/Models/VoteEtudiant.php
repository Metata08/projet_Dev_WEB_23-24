<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteEtudiant extends Model
{
    protected $table = 'vote_etudiants';

    protected $fillable = [
        'etudiant_id',
        'vote_id',
        'voted_at',
        // 'choix', si nécessaire
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'id_etudiant');
    }

    public function vote()
    {
        return $this->belongsTo(Votes::class, 'vote_id', 'id_vote');
    }
}
