<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Etudiant;
use App\Models\UFR;
use App\Models\Listes;
use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    //fonction dashboard admin
    public function dashboardAdmin(){
        $nombreDePostes = DB::table('u_f_r_s')->count();
        $nombreDeCandidats = DB::table('listes')->count();
        $nombreTotalElecteurs = DB::table('etudiants')->count();
        $nombreElecteursVotants = DB::table('vote_etudiants')->distinct('etudiant_id')->count();
        $positions = DB::table('vote_etudiants')
        ->join('listes', 'vote_etudiants.list_id', '=', 'listes.id_list')
        ->join('u_f_r_s', 'u_f_r_s.id_ufr', '=', 'listes.ufr_id')
        ->select('u_f_r_s.nom as position', 'listes.name_list as candidat', DB::raw('COUNT(vote_etudiants.id) as nombre_de_votes'))
        ->groupBy('u_f_r_s.nom', 'listes.id_list')
        ->orderBy('u_f_r_s.nom')
        ->orderByDesc('nombre_de_votes')
        ->get();

        // $positions =  @json_encode($position);

        return view('admin.home', compact(
            'nombreDePostes',
            'nombreDeCandidats',
            'nombreTotalElecteurs',
            'nombreElecteursVotants',
            'positions'
        ));
    }

    public function logoutAdmin(){
        return redirect()->route('admin');
    }

    public function listeCandidats(){
        $listesC = Listes::all();
        return view('admin.candidates', compact('listesC'));
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
            'name_list' => $request->nom,
            'programme' => $request->programme,
            'ufr_id' => $ufr->id_ufr, 
        ]);

        return redirect()->route('listeCandidats');
    }


    // Vérifier l'authentification
    public function loginAdmin(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Vérification dans la table `admins`
        $admin = Admin::where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if ($admin) {
            // Rediriger vers le dashboard
            return redirect()->route('dashboardAdmin');
        }

        // Redirection avec erreur
        return back()->with('error', 'Identifiants incorrects.');
    }

}