<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\KP;
use App\Models\SuratBimbingan;

class AdminController extends Controller
{
    //
    public function suratBimbinganIndex(){
        $kps = KP::with('mahasiswa', 'metadata', 'pembimbing','surat_bimbingan')
            ->whereHas('proposal', function ($query) {
                $query->where('status', 'done');
            })
            ->get();
        $data['kps'] = $kps;
        return view('admin.suratBimbingan',$data);
    }

    public function suratBimbinganPengambilan(string $id) {
        try {
            $kp = KP::with('surat_bimbingan')->findOrFail($id);
    
            if ($kp->surat_bimbingan) {
                $kp->surat_bimbingan->update([
                    'status_pengambilan' => !$kp->surat_bimbingan->status_pengambilan,
                    'tanggal_pengambilan' => now(),
                ]);
            } else {
                SuratBimbingan::create([
                    'kp_id' => $kp->id,
                    'status_pengambilan' => true,
                    'tanggal_pengambilan' => now(),
                ]);
            }
    
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exception
            return response()->json(['message' => 'Failed to update data', 'error' => $e->getMessage()], 500);
        }
    }    
}
