<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Etudiant;
use App\Models\Listes;
use Illuminate\View\View;

class login_controller extends Controller
{
    // Accueil
    public function accueil(): View
    {
        return view('ugbvote');
    }

    // Formulaire de connexion
    public function showLoginForm(): View
    {
        return view('user.login');
    }

    // Formulaire d'inscription
    public function inscription(): View
    {
        return view('user.inscription');
    }

    // Traitement de la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Stocker l'UFR dans la session
            session(['ufr_id' => $user->ufr_id]);

            // Récupérer les listes pour l'UFR de l'étudiant
            $listes = Listes::where('ufr_id', $user->ufr_id)->get();

            if ($listes->isEmpty()) {
                return view('user.election')
                    ->with('message', 'Aucune liste disponible pour votre UFR pour l\'instant.')
                    ->with('etudiant', $user);
            }

            return view('user.election')
                ->with('listes', $listes)
                ->with('etudiant', $user)
                ->with('success', 'Connexion réussie');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['login' => 'E-mail ou mot de passe incorrect']);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Déconnexion réussie');
    }

    // Partage des données d'étudiant avec les vues
    public function compose(View $view)
    {
        $view->with('etudiant', Auth::check() ? Auth::user() : null);
    }
}