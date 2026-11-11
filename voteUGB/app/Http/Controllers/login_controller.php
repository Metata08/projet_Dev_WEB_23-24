<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Listes;
use App\Models\UFR;
use App\Models\VoteEtudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class login_controller extends Controller
{
    /** Page d'accueil publique, avec quelques chiffres clés. */
    public function accueil()
    {
        return view('ugbvote', [
            'chiffres' => [
                'ufr' => UFR::count(),
                'listes' => Listes::count(),
                'inscrits' => Etudiant::count(),
                'votes' => VoteEtudiant::count(),
            ],
        ]);
    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function inscription()
    {
        return view('user.inscription', ['ufrs' => UFR::orderBy('nom')->get()]);
    }

    public function login(Request $request)
    {
        $identifiants = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        $identifiants['email'] = mb_strtolower(trim($identifiants['email']));

        if (! Auth::guard('web')->attempt($identifiants)) {
            // Message volontairement générique : on ne révèle pas si le compte existe.
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'E-mail ou mot de passe incorrect.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('election'))
            ->with('success', 'Connexion réussie. Bienvenue '.ucfirst(Auth::user()->prenom).' !');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous êtes déconnecté. À bientôt !');
    }
}
