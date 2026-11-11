<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Un bulletin déposé par un étudiant pour un scrutin.
 * L'unicité (etudiant_id, vote_id) est garantie par la base de données.
 */
class VoteEtudiant extends Model
{
    protected $table = 'vote_etudiants';

    protected $fillable = ['etudiant_id', 'vote_id', 'list_id', 'voted_at'];

    protected $casts = ['voted_at' => 'datetime'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'id_etudiant');
    }

    public function vote()
    {
        return $this->belongsTo(Votes::class, 'vote_id', 'id_vote');
    }

    public function liste()
    {
        return $this->belongsTo(Listes::class, 'list_id', 'id_list');
    }
}
