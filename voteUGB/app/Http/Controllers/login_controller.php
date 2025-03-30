<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Etudiant;


class login_controller extends Controller
{
    // accueil
    public function accueil(): View
    {
        return view('ugbvote');
    }
    public function showLoginForm(): View
    {
        return view('user.login');
    }


    public function connecter()
    {
        return view('user.election');
    }
    // inscription
    public function inscription()
    {
        return view('user.inscription');
    }



    // pour gerer la connection des users 
    public function login(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Vérification et tentative d'authentification
        if (Auth::attempt(['mail' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Regénérer la session pour la sécurité
            return redirect()->route('election')->with('success', 'Connexion réussie');
        }

        // Si la connexion échoue
        return back()->withErrors(['login' => 'E-mail ou mot de passe incorrect']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Déconnexion réussie');
    }
}
