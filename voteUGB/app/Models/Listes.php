<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listes extends Model
{
    protected $table = 'listes';

    // Définir la clé primaire si elle n'est pas "id"
    protected $primaryKey = 'id_list';


    use HasFactory;
    protected $fillable = ['id_list', 'programme', 'titre', 'name_list', 'ufr_id'];


    public function ufr()
    {
        return $this->belongsTo(UFR::class);
    }

    /* public function membres()
    {
        return $this->hasMany(MembresListe::class);
    } */

    public function membres()
    {
        return $this->hasMany(MembresListe::class, 'list_id', 'id_list');
    }

    public function voteEtudiants()
    {
        return $this->hasMany(VoteEtudiant::class, 'list_id', 'id_list');
    }

    
}
