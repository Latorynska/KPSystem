<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    //
    public function index(){
        return view('mahasiswa.bimbingan');
    }
}
