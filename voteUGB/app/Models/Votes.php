<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Votes extends Model
{
    use HasFactory;

    protected $table = 'votes';  // Assurez-vous que le nom de la table est correct

    protected $primaryKey = 'id_vote'; // Définir la clé primaire personnalisée
    public $incrementing = true; // Indique que ce n'est pas une clé auto-incrémentée
    protected $keyType = 'int'; // Mettre 'int' si c'est un entier

    protected $fillable = ['id_vote', 'date_debut', 'date_fin'];

    public function ufrs(): HasMany
    {
        return $this->hasMany(UFR::class, 'vote_id', 'id_vote');
    }
}

