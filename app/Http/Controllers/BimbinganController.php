<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KP;

class BimbinganController extends Controller
{
    //
    public function index()
    {
        $mahasiswa_id = auth()->id();
        $kp = KP::with('bimbingans', 'pembimbing.grup_bimbingan')
                ->where('mahasiswa_id', $mahasiswa_id)
                ->firstOrFail();
        $data['kp'] = $kp;
        return view('mahasiswa.bimbingan', $data);
    }

}
