<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Etudiant;
use App\Models\UFR;
use App\Models\Listes;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //fonction dashboard admin
    public function dashboardAdmin(){
        $nombreDePostes = DB::table('ufrs')->count();
        $nombreDeCandidats = DB::table('listes')->count();
        $nombreTotalElecteurs = DB::table('etudiants')->count();
        $nombreElecteursVotants = DB::table('votes')->distinct('etudiant_id')->count();
        $positions = DB::table('votes')
            ->join('membres_listes', 'membres_listes.id_membre', '=', 'votes.etudiant_id')
            ->join('listes', 'listes.id_list', '=', 'membres_listes.list_id')
            ->join('ufrs', 'ufrs.id_ufr', '=', 'listes.ufr_id')
            ->select('ufrs.nom as position', 'membres_listes.id_membre as candidat', DB::raw('COUNT(votes.id_vote) as nombre_de_votes'))
            ->groupBy('ufrs.nom', 'membres_listes.id_membre')
            ->get();


        return view('admin.home', compact(
            'nombreDePostes',
            'nombreDeCandidats',
            'nombreTotalElecteurs',
            'nombreElecteursVotants',
            'positions'
        ));
    }

    public function logoutAdmin(){
        return view('admin.includes.logout');
    }

    public function listeCandidats(){
        $listes = Listes::all();
        return view('admin.candidates', compact('listes'));
    }

    public function listePostes(){
        return view('admin.postes');
    }

    public function listeElecteurs()
    {
        $etudiants = Etudiant::all(); // Récupérer tous les électeurs
        return view('admin.electeurs', compact('etudiants'));
    }

    public function deleteElecteur($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        if ($etudiant) {
            $etudiant->delete();
            return redirect()->route('listeElecteurs')->with('success', 'Électeur supprimé avec succès.');
        }
        return redirect()->route('listeElecteurs')->with('error', 'Électeur introuvable.');
    }


    public function enregistrerList(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'programme' => 'required|string',
            'ufr' => 'required|string', // Nom de l'UFR
        ]);

        // Rechercher l'ID de l'UFR à partir du nom
        $ufr = UFR::where('nom', $request->ufr)->first();

        // Vérifier si l'UFR existe bien
        if (!$ufr) {
            return redirect()->back()->with('error', 'UFR non trouvé.');
        }

        // Insérer les données avec l'ID de l'UFR
        DB::table('listes')->insert([
            'titre' => $request->titre,
            'name_list' => $request->nom,
            'programme' => $request->programme,
            'ufr_id' => $ufr->id_ufr, // Insère l'ID au lieu du nom
        ]);

        return redirect()->back()->with('success', 'Liste ajoutée avec succès.');
    }

}