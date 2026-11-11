<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UFR extends Model
{
    use HasFactory;

    protected $table = 'u_f_r_s';

    protected $primaryKey = 'id_ufr';

    protected $fillable = ['nom', 'vote_id'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'ufr_id', 'id_ufr');
    }

    public function listes()
    {
        return $this->hasMany(Listes::class, 'ufr_id', 'id_ufr');
    }

    /** Scrutin rattaché à l'UFR. */
    public function scrutin()
    {
        return $this->belongsTo(Votes::class, 'vote_id', 'id_vote');
    }

    public function getSigleAttribute(): string
    {
        return mb_strtoupper($this->nom);
    }
}
