<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\KP;
use App\Models\KPMetadata;
use App\Models\Laporan;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    //
    public function lists() {
        $kps = KP::with([
            'mahasiswa',
            'metadata',
            'bimbingans',
            'penilaian'
        ])
        ->when(auth()->user()->hasRole('pembimbing'), function ($query) {
            return $query->where('pembimbing_id', auth()->id());
        })
        ->when(auth()->user()->hasRole('kordinator'), function ($query) {
            return $query;
        })
        ->get();
    
        $data['kps'] = $kps;
        return view('kp.list', $data);
    }
}
