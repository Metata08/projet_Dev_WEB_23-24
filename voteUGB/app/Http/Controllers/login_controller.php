<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class login_controller extends Controller
{
    public function showLoginForm()
    {
        return view('user.login');
    }


    public function connecter()
    {
        return view('user.election');
    }
// inscriotion
    public function inscription()
    {
        return view('user.inscription');
    }


/* 
    public function login(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenter de s'authentifier
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->remember)) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ]);
    } */
}
