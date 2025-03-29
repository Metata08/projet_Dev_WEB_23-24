<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listes extends Model
{
    use HasFactory;
    protected $fillable = ['id_list', 'programme', 'name_list', 'ufr_id'];

    public function ufr()
    {
        return $this->belongsTo(UFR::class);
    }

    public function membres()
    {
        return $this->hasMany(MembresListe::class);
    }
}

