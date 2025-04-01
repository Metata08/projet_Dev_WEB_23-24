<?php

namespace App\Http\Controllers;

use App\Models\VoteEtudiant;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class inscription_controller extends Controller
{
    public function showInscriptionForm()
    {
        return view('user.inscription'); // Votre formulaire d'inscription
    }

    public function register(Request $request)
    {
        // Validation des données du formulaire
        $data = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom'    => 'required|string|max:255',
            'code'   => 'required|string|max:255|unique:etudiants,code_etudiant', // Vérifie que le code est unique dans la table etudiants
            'email'  => 'required|email|max:255|unique:etudiants,mail',            // Vérifie que l'email est unique
            'ufr'    => 'required|exists:u_f_r_s,id_ufr', // Vérifie que l'ID de l'UFR existe dans la table u_f_r_s
            'password' => 'required|string|min:6|confirmed', // Le champ password_confirmation doit être présent dans le formulaire
        ]);

        // Création de l'étudiant en base de données
        $etudiant = Etudiant::create([
            'prenom'        => $data['prenom'],
            'nom'           => $data['nom'],
            'code_etudiant' => $data['code'],  // Correspond à votre champ code dans le formulaire
            'mail'          => $data['email'],
            'ufr_id'        => $data['ufr'],
            'mdp'           => Hash::make($data['password']),
        ]);

        // Optionnel : Connecter l'utilisateur automatiquement après l'inscription
        // Auth::login($etudiant);

        // Redirection vers une page de succès (par exemple, dashboard ou election)
        return redirect()->route('login')->with('success', 'Inscription réussie !');
    }



}
