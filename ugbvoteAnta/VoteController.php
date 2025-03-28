<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index()
    {
        return view('vote'); // Assure-toi que 'vote.blade.php' existe dans resources/views/
    }

    public function vote($id)
    {
        return view('vote', compact('id'));
    }

    public function storeVote(Request $request, $id)
    {
        // Logique pour enregistrer le vote
    }
}
