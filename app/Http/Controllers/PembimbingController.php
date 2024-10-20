<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\KP;
use App\Models\User;

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
        return view('pembimbing.bimbinganList',$data);
    }

    public function lapanganLists(){
        $pembimbingLapangans = User::whereHas('roles', function($query){
            $query->where('name','pembimbing_lapangan');
        })->get();
        $data['pembimbingLapangans'] = $pembimbingLapangans;
        return view('pembimbing.lapanganLists',$data);
    }
    
    // create new pembimbing lapangan data
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nomor_induk' => 'required|unique:users,nomor_induk',
            'email' => 'required|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $newPembimbingLapangan = User::create([
                'nomor_induk' => $request->nomor_induk,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('Password123'),
            ]);
            $newPembimbingLapangan->assignRole('pembimbing_lapangan');
            if ($request->filled('kp_id')) {
                $kp = KP::findOrFail($request->kp_id);
                $kp->update([
                    'pembimbing_lapangan_id' => $newPembimbingLapangan->id,
                ]);
            }

            return response()->json(['message' => 'Pembimbing Lapangan berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan Pembimbing Lapangan'], 500);
        }
    }

}
