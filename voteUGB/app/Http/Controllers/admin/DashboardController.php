<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Candidate;
use App\Models\Voter;
use App\Models\Vote;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        // Vérification manuelle du rôle admin
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                return redirect()->route('loginAdmin')->with('error', 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $stats = [
            'positions' => Position::count(),
            'candidates' => Candidate::count(),
            'voters' => Voter::count(),
            'votes' => Vote::distinct('voter_id')->count('voter_id'),
        ];

        $positions = Position::with(['candidates' => function($query) {
            $query->withCount('votes');
        }])->orderBy('priority')->get();

        return view('admin.dashboard', compact('stats', 'positions'));
    }
}