<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listes extends Model
{
    use HasFactory;

    protected $table = 'listes';

    protected $primaryKey = 'id_list';

    protected $fillable = ['programme', 'titre', 'name_list', 'ufr_id', 'slogan', 'logo', 'campagne_validee'];

    protected $casts = ['campagne_validee' => 'boolean'];

    public function ufr()
    {
        return $this->belongsTo(UFR::class, 'ufr_id', 'id_ufr');
    }

    public function membres()
    {
        return $this->hasMany(MembresListe::class, 'list_id', 'id_list');
    }

    public function bulletins()
    {
        return $this->hasMany(Bulletin::class, 'list_id', 'id_list');
    }

    public function propositions()
    {
        return $this->hasMany(Proposition::class, 'list_id', 'id_list');
    }

    public function realisations()
    {
        return $this->hasMany(Realisation::class, 'list_id', 'id_list')->orderByDesc('annee');
    }

    public function getSigleAttribute(): string
    {
        return mb_strtoupper(mb_substr($this->name_list, 0, 1));
    }
}
