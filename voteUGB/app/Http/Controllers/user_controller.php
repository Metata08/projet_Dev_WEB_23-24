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
}
