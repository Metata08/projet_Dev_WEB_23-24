<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UFR extends Model
{
    use HasFactory;

    // Si votre table s'appelle 'ufrs' (convention Laravel)
    protected $table = 'ufrs'; 
    
    // Si vous utilisez 'id_ufr' comme clé primaire
    protected $primaryKey = 'id_ufr';
    
    public $incrementing = true; // Si c'est un auto-increment
    protected $keyType = 'int';  // Type de la clé primaire
    
    protected $fillable = ['nom']; // 'id_ufr' n'est pas nécessaire ici

    // Relation avec les étudiants
    public function etudiants(): HasMany
    {
        return $this->hasMany(Etudiant::class, 'ufr_id', 'id_ufr');
    }

    // Relation avec les listes
    public function listes(): HasMany
    {
        return $this->hasMany(Liste::class, 'ufr_id', 'id_ufr');
    }

    // Relation avec les votes (à vérifier selon votre structure)
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'ufr_id', 'id_ufr');
    }
}