<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    /** Thèmes communs à toutes les listes : ils rendent les programmes comparables. */
    public const THEMES = [
        'pedagogie' => 'Pédagogie',
        'social' => 'Vie sociale',
        'numerique' => 'Numérique',
        'restauration' => 'Restauration & logement',
        'sport' => 'Sport & culture',
        'insertion' => 'Stages & insertion',
    ];

    protected $fillable = ['list_id', 'theme', 'texte'];

    public function getThemeLibelleAttribute(): string
    {
        return self::THEMES[$this->theme] ?? ucfirst($this->theme);
    }
}
