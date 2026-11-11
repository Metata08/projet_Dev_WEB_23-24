<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalAdmin extends Model
{
    public $timestamps = false;

    protected $fillable = ['admin_id', 'admin_nom', 'action', 'details', 'ip', 'created_at'];

    protected $casts = ['created_at' => 'datetime'];
}
