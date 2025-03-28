<?php

namespace App\Http\Controllers;

use App\Models\Etudiants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    public function ajouterEtudiants(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email',
            'ufr' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'Cet email est déjà utilisé',
            'password.confirmed' => 'Les mots de passe ne correspondent pas'
        ]);

        //Vérification de l'existence dans etudiants_officiels
        $etudiantOfficiel = DB::table('etudiants_officiels')
            ->where('email_etudiant', $request->input('email'))
            ->first();

        if (!$etudiantOfficiel) {
            return redirect()->back()->withInput()->with('error', 'Vous n\'êtes pas un étudiant officiel.');
        }

        try {
            $etudiant = new Etudiants();
            $etudiant->prenom = $request->input('prenom');
            $etudiant->nom = $request->input('nom');
            $etudiant->email = $request->input('email');
            $etudiant->ufr = $request->input('ufr');
            $etudiant->password = Hash::make($request->input('password'));
            $etudiant->save();

            return redirect('/')->with('success', 'Inscription réussie');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'inscription.');
        }
    }
}
