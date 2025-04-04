<?php

namespace App\Http\Controllers;

use App\Models\VoteEtudiant;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'code'   => [
                'required',
                'string',
                'max:255',
                'unique:etudiants,code_etudiant',
                Rule::exists('etudiant_officiels', 'code') // Le code doit exister dans la table etudiant_officiels
            ],
            'email'  => 'required|email|max:255|unique:etudiants,email',           
            'ufr'    => 'required|exists:u_f_r_s,id_ufr', // Vérifie que l'ID de l'UFR existe dans la table u_f_r_s
            'password' => 'required|string|min:6|confirmed', // Le champ password_confirmation doit être présent dans le formulaire
        ]);

        // Création de l'étudiant en base de données
        $etudiant = Etudiant::create([
            'prenom'        => $data['prenom'],
            'nom'           => $data['nom'],
            'code_etudiant' => $data['code'],  // Correspond à votre champ code dans le formulaire
            'email'          => $data['email'],
            'ufr_id'        => $data['ufr'],
            'mdp'           => Hash::make($data['password']),
        ]);

       

        // Redirection vers la page de  connexion
        return redirect()->route('login')->with('success', 'Inscription réussie !');
    }
}