<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Etudiant;
use App\Models\Listes;
use Illuminate\Contracts\View\View as ViewView;

class login_controller extends Controller
{
    // accueil
    public function accueil()
    {
        return view('ugbvote');
    }
    public function showLoginForm()
    {
        return view('user.login');
    }


    /*  public function connecter()
    {
        return view('user.election');
    } */



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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            $user = Auth::user();
            $request->session()->put('ufr_id', $user->ufr_id);

            // Par exemple, récupérer les listes de vote pour cet UFR
            $listes = Listes::where('ufr_id',  $user->ufr_id)->get();

            if ($listes->isEmpty()) {#
                return view('user.election')->with('message', 'Aucune liste disponible pour votre UFR pour l\'instant.');
            }

            return view('user.election', ['listes' => $listes,'etudiant'=> $user])->with('success', 'Connexion réussie');
            // return redirect()->route('election', ['ufr_id' => $user->ufr_id])->with('success', 'Connexion réussie');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Regénérer la session pour la sécurité
            return redirect()->route('election')->with('success', 'Connexion réussie');
        }

        // Si la connexion échoue
        return back()->withErrors(['login' => 'E-mail ou mot de passe incorrect']);
    }
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Déconnexion réussie');
 
   }


   public function compose(ViewView $view)
    {
        $view->with('etudiant', Auth::check() ? Auth::user() : null);
    }
}
