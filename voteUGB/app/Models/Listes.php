<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listes extends Model
{
    use HasFactory;

    protected $table = 'listes';

    protected $primaryKey = 'id_list';

    protected $fillable = ['programme', 'titre', 'name_list', 'ufr_id'];

    public function ufr()
    {
        return $this->belongsTo(UFR::class, 'ufr_id', 'id_ufr');
    }

    public function membres()
    {
        return $this->hasMany(MembresListe::class, 'list_id', 'id_list');
    }

    public function voteEtudiants()
    {
        return $this->hasMany(VoteEtudiant::class, 'list_id', 'id_list');
    }
}
