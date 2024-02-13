<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\KP;
use App\Models\User;
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

    public function resetMahasiswaPassword(Request $request, string $id){
        if(!Auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'unaothorized'], 401);
        }
        $validator = Validator::make($request->all(), [
            'admin_password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $adminPassword = $request->input('admin_password');
        $currentUser = auth()->user();
        if (!Hash::check($adminPassword, $currentUser->password)) {
            return response()->json(['message' => 'Admin password is incorrect'], 422);
        }

        try{
            $mahasiswa = User::findOrFail($id);
            $mahasiswa->update([
                'password' => Hash::make('Password123')
            ]);
            return response()->json(['message' => 'Password Mahasiswa Berhasil diatur ulang ke semula'], 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Failed to update data'], 500);
        }
    }
}
