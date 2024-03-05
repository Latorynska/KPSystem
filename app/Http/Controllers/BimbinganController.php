<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


use App\Models\KP;
use App\Models\User;
use App\Models\Bimbingan;

class BimbinganController extends Controller
{
    public function lists(){
        $kps = KP::with('metadata', 'proposal', 'surat_bimbingan', 'mahasiswa', 'pembimbing', 'pembimbing_lapangan')
            ->whereHas('proposal', function ($query) {
                $query->where('status', 'done');
            })
            ->get();
        
        $pembimbingLapangans = User::whereHas('roles', function($query){
            $query->where('name','pembimbing_lapangan');
        })->get();
        foreach ($kps as $kp) {
            $dosenBimbinganCount = $kp->bimbingans()->where('tipe', 'dosen')->count();
            $lapanganBimbinganCount = $kp->bimbingans()->where('tipe', 'lapangan')->count();
            $kp->dosen_bimbingan_count = $dosenBimbinganCount;
            $kp->lapangan_bimbingan_count = $lapanganBimbinganCount;
        }

        $data['kps'] = $kps;
        $data['pembimbing_lapangans'] = $pembimbingLapangans;
        return view('bimbingan.lists', $data);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'tipe' => 'required',
            'isi' => 'required',
            'tanggal' => 'required|date_format:Y-m-d',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // return response()->json(['message' => $request->all()], 422);
        try{
            $kp = KP::where('mahasiswa_id', Auth()->id())->with('surat_izin')->firstOrFail();
            $newBimbingan = Bimbingan::create([
                'kp_id' => $kp->id,
                'isi' => $request->isi,
                'tanggal' => $request->tanggal,
                'tipe' => $request->tipe,
                'status' => 'awaited',
            ]);
            return redirect()->route('mahasiswa.bimbingan');
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Failed to store file'], 500);
        }
    }

    public function assignPembimbingLapangan(Request $request, string $id){
        $kp = KP::findOrFail($id);
        $request->validate([
            'pembimbing_id' => 'required'
        ]);
        // return response()->json(['message' => $request->all()], 422);
        try{
            $kp->update([
                'pembimbing_lapangan_id' => $request->pembimbing_id,
            ]);
            $notification = [
                'message' => 'Data KP berhasil diperbarui',
                'alert-type' => 'success'
            ];
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Failed to update KP data','error : ' => $e], 500);
        }
    }

    public function bimbinganList(){
        if (auth()->user()->hasRole('pembimbing_lapangan')) {
            $kps = KP::where('pembimbing_lapangan_id', auth()->id())
                ->with('mahasiswa', 'metadata','bimbingans')
                ->whereHas('bimbingans', function ($query) {
                    $query->where('tipe', 'lapangan');
                })
                ->get();
        } else if (auth()->user()->hasRole('pembimbing')) {
            $kps = KP::where('pembimbing_id', auth()->id())
                ->with('mahasiswa', 'metadata','bimbingans')
                ->whereHas('bimbingans', function ($query) {
                    $query->where('tipe', 'lapangan');
                })
                ->get();
        }

        $data['kps'] = $kps;
        // dd($data);
        return view('pembimbingLapangan.bimbinganList', $data);
    }

}