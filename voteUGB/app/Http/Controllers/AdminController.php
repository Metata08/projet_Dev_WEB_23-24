<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //fonction de connexion pour admin
    public function loginAdmin(){
        return view('admin.index');
    }

    //fonction dashboard admin
    public function dashboardAdmin(){
        return view('admin.home');
    }

    public function logoutAdmin(){
        return view('admin.includes.logout');
    }
}
