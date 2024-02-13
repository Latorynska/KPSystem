<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\KP;

class PembimbingController extends Controller
{
    public function lists(){
        $currentUserId = Auth::id();
    
        $kps = KP::with('mahasiswa', 'metadata','surat_bimbingan')
                ->whereHas('proposal', function ($query) {
                    $query->where('status', 'done');
                })
                ->whereHas('pembimbing', function ($query) use ($currentUserId) {
                    $query->where('pembimbing_id', $currentUserId);
                })
                ->whereHas('surat_bimbingan', function ($query) {
                    $query->where('status_pengambilan', true);
                })
                ->get();
    
        $data['kps'] = $kps;
        return view('pembimbing.bimbinganLists',$data);
    }
}
