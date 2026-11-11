<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Émargement : atteste qu'un étudiant a voté à un scrutin, sans dire pour qui.
 * L'unicité (etudiant_id, vote_id) est garantie par la base de données.
 */
class Emargement extends Model
{
    public $timestamps = false;

    protected $fillable = ['etudiant_id', 'vote_id', 'voted_at'];

    protected $casts = ['voted_at' => 'datetime'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'id_etudiant');
    }
}
