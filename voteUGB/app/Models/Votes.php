<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Un scrutin : une période de vote rattachée à une ou plusieurs UFR.
 */
class Votes extends Model
{
    use HasFactory;

    public const A_VENIR = 'a_venir';

    public const OUVERT = 'ouvert';

    public const CLOS = 'clos';

    protected $table = 'votes';

    protected $primaryKey = 'id_vote';

    protected $fillable = ['date_debut', 'date_fin'];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function ufrs()
    {
        return $this->hasMany(UFR::class, 'vote_id', 'id_vote');
    }

    public function bulletins()
    {
        return $this->hasMany(VoteEtudiant::class, 'vote_id', 'id_vote');
    }

    /** Le scrutin est ouvert du début du premier jour à la fin du dernier jour. */
    public function getStatutAttribute(): string
    {
        $maintenant = now();

        if ($maintenant->lt($this->date_debut->copy()->startOfDay())) {
            return self::A_VENIR;
        }

        if ($maintenant->gt($this->date_fin->copy()->endOfDay())) {
            return self::CLOS;
        }

        return self::OUVERT;
    }

    public function estOuvert(): bool
    {
        return $this->statut === self::OUVERT;
    }

    /** Instant utilisé par le compte à rebours (ouverture ou clôture). */
    public function getEcheanceAttribute()
    {
        return $this->statut === self::A_VENIR
            ? $this->date_debut->copy()->startOfDay()
            : $this->date_fin->copy()->endOfDay();
    }
}
