<?php

namespace App\Support;

use App\Models\JournalAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Journal des actions d'administration (qui a fait quoi, quand, depuis où).
 */
class Journal
{
    public static function note(string $action, ?string $details = null): void
    {
        $admin = Auth::guard('admin')->user();

        JournalAdmin::create([
            'admin_id' => $admin?->id,
            'admin_nom' => $admin?->name,
            'action' => $action,
            'details' => $details ? Str::limit($details, 480) : null,
            'ip' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
