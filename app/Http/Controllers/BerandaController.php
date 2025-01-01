<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class BerandaController extends Controller
{
    public function index(){

        $lists = User::all();
        return view('beranda.index', [
            'judul'=>'Peta',
            'user'=> $lists
        ]);
    }
}
