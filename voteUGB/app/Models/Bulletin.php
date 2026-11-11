<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Bulletin anonyme déposé dans l'urne : aucun lien avec l'étudiant, ni date, ni numéro d'ordre.
 */
class Bulletin extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['vote_id', 'list_id', 'recu_hash'];

    protected $hidden = ['recu_hash'];

    /** Identifiants aléatoires (UUID v4) : ils ne révèlent pas l'ordre de dépôt. */
    public function newUniqueId(): string
    {
        return (string) \Illuminate\Support\Str::uuid();
    }

    /** Génère un reçu lisible, sans caractères ambigus (0/O, 1/I…). */
    public static function nouveauRecu(): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $groupes = [];

        for ($g = 0; $g < 3; $g++) {
            $groupe = '';
            for ($i = 0; $i < 4; $i++) {
                $groupe .= $alphabet[random_int(0, strlen($alphabet) - 1)];
            }
            $groupes[] = $groupe;
        }

        return 'UGB-'.implode('-', $groupes);
    }

    public static function empreinte(string $recu): string
    {
        return hash('sha256', preg_replace('/[^A-Z0-9]/', '', mb_strtoupper($recu)));
    }

    public function liste()
    {
        return $this->belongsTo(Listes::class, 'list_id', 'id_list');
    }

    public function scrutin()
    {
        return $this->belongsTo(Votes::class, 'vote_id', 'id_vote');
    }
}
