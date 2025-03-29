<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembresListe extends Model
{
    use HasFactory;
    protected $fillable = ['id_membre', 'list_id','tete_liste'];

    public function liste()
    {
        return $this->belongsTo(Listes::class);
    }
}

