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
            'mail' => 'required|email',
            'mdp' => 'required|string',
        ]);

        // Vérifier si l'utilisateur existe
        $etudiant = Etudiant::where('mail', $request->mail)->first();

        if (!$etudiant || $request->mdp !== $etudiant->mdp) {

            return back()->withErrors(['login' => 'E-mail ou mot de passe incorrect']);
        }

        // Authentifier l'utilisateur
        Auth::login($etudiant,true);

        return redirect()->route('election')->with('success', 'Connexion réussie');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Déconnexion réussie');
    }
}
