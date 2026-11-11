<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as ReglesMotDePasse;

/**
 * Mot de passe oublié (étudiants) : lien à usage unique envoyé par e-mail, valable 60 minutes.
 */
class MotDePasseController extends Controller
{
    public function demande()
    {
        return view('user.motDePasseOublie');
    }

    public function envoyerLien(Request $request)
    {
        $donnees = $request->validate(['email' => 'required|email|max:255']);

        try {
            Password::broker('etudiants')->sendResetLink(['email' => mb_strtolower(trim($donnees['email']))]);
        } catch (\Throwable $e) {
            report($e);
        }

        // Réponse identique que le compte existe ou non : on ne révèle pas qui est inscrit.
        return back()->with('success', 'Si un compte existe pour cette adresse, un lien de réinitialisation vient de lui être envoyé.');
    }

    public function formulaire(Request $request, string $token)
    {
        return view('user.reinitialiser', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reinitialiser(Request $request)
    {
        $donnees = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email|max:255',
            'password' => ['required', 'confirmed', 'max:255', ReglesMotDePasse::min(8)->letters()->numbers()],
        ], ['password.confirmed' => 'Les deux mots de passe ne correspondent pas.'], ['password' => 'mot de passe']);

        $donnees['email'] = mb_strtolower(trim($donnees['email']));

        $statut = Password::broker('etudiants')->reset(
            $donnees + ['password_confirmation' => $request->input('password_confirmation')],
            function (Etudiant $etudiant, string $motDePasse) {
                $etudiant->forceFill(['mdp' => Hash::make($motDePasse)])->save();
            }
        );

        if ($statut !== Password::PASSWORD_RESET) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Ce lien de réinitialisation est invalide ou a expiré. Refaites une demande.']);
        }

        return redirect()->route('login')->with('success', 'Mot de passe modifié. Vous pouvez vous connecter.');
    }
}
