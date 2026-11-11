<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembresListe extends Model
{
    use HasFactory;

    protected $fillable = ['id_membre', 'list_id', 'tete_liste', 'role'];

    protected $casts = ['tete_liste' => 'boolean'];

    public function liste()
    {
        return $this->belongsTo(Listes::class, 'list_id', 'id_list');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_membre', 'id_etudiant');
    }
}
