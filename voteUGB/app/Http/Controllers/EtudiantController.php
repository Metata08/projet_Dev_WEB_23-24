<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Ufr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    public function ajouterEtudiants(Request $request)
{

    $validatedData = $request->validate([
        'prenom' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'email' => 'required|email|unique:etudiants,email',
        'ufr' => 'required|exists:ufrs,nom',
        'password' => 'required|min:6|confirmed',
    ], [
        'email.unique' => 'Cet email est déjà utilisé',
        'password.confirmed' => 'Les mots de passe ne correspondent pas',
    ]);

    try {
        $ufr = Ufr::where('nom', $validatedData['ufr'])->firstOrFail();

        $etudiant = Etudiant::create([
            'prenom' => $validatedData['prenom'],
            'nom' => $validatedData['nom'],
            'email' => $validatedData['email'],
            'ufr_id' => $ufr->id_ufr,
            'mdp' => Hash::make($validatedData['password'])
        ]);

        auth()->login($etudiant);

        return redirect('/systemevote')->with('success', 'Inscription réussie');
        
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Erreur lors de l\'inscription: '.$e->getMessage());
    }
}
}