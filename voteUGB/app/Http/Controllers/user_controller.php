<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class user_controller extends Controller    
{
    //fonction index 

    public function index():View   {
        return view('user.header-pricipal');
    }

    //fonction detailListe
    public function detailListe():View {
        return view('user.detailListe');
    }

    //fonction vote
    public function vote():View {
        return view('user.vote');
    }


    //fonction page_vote
    public function page_vote():View {
        return view('user.systemevote');
    }
}
