<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class inscription_controller extends Controller
{
    public function register(Request $request)
    {
        $request->merge([
            'email' => mb_strtolower(trim((string) $request->input('email'))),
            'code' => trim((string) $request->input('code')),
        ]);

        $donnees = $request->validate([
            'prenom' => ['required', 'string', 'max:100', "regex:/^[\pL\s'\-]+$/u"],
            'nom' => ['required', 'string', 'max:100', "regex:/^[\pL\s'\-]+$/u"],
            'code' => [
                'required', 'string', 'max:50',
                // Seuls les étudiants validés par l'université peuvent s'inscrire…
                Rule::exists('etudiant_officiels', 'code'),
                // … et un code ne peut servir qu'à un seul compte.
                Rule::unique('etudiants', 'code_etudiant'),
            ],
            'email' => ['required', 'email', 'max:255', Rule::unique('etudiants', 'email')],
            'ufr' => ['required', Rule::exists('u_f_r_s', 'id_ufr')],
            'password' => ['required', 'confirmed', 'max:255', Password::min(8)->letters()->numbers()],
        ], [
            'prenom.regex' => 'Le prénom ne doit contenir que des lettres.',
            'nom.regex' => 'Le nom ne doit contenir que des lettres.',
            'code.exists' => "Ce code étudiant n'est pas reconnu par l'université.",
            'code.unique' => 'Un compte existe déjà pour ce code étudiant.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
        ], [
            'prenom' => 'prénom',
            'code' => 'code étudiant',
            'email' => 'adresse e-mail',
            'ufr' => 'UFR',
            'password' => 'mot de passe',
        ]);

        Etudiant::create([
            'prenom' => $donnees['prenom'],
            'nom' => $donnees['nom'],
            'code_etudiant' => $donnees['code'],
            'email' => $donnees['email'],
            'ufr_id' => $donnees['ufr'],
            'mdp' => Hash::make($donnees['password']),
        ]);

        return redirect()->route('login')
            ->with('success', 'Inscription réussie ! Connectez-vous pour voter.');
    }
}
