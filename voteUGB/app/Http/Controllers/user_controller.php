<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class user_controller extends Controller    
{

    //fonction detailListe
    public function detailListe():View {
        return view('user.detailListe');
    }

    //fonction election
    public function election():View {
        return view('user.election');
    }


    //fonction page_vote
    public function page_vote():View {
        return view('user.systemevote');
    }

    //fonction resultat
    public function resultat():View {
        return view('user.resultat');
    }
}
