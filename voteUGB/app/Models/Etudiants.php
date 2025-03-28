<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Etudiants extends Model
{
    use HasFactory;

    protected $table = 'etudiants'; // Spécification du nom de la table
    protected $fillable = ['prenom', 'nom', 'email', 'ufr', 'password', 'tete'];
}
