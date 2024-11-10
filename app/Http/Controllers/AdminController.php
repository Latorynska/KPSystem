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

    public function resetUserPassword(Request $request, string $id){
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
            return response()->json(['message' => 'Password Berhasil diatur ulang ke semula'], 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Failed to update data'], 500);
        }
    }

    public function administratifSeminarIndex() {
        $kps = KP::with('mahasiswa', 'metadata', 'pembimbing','penguji','surat_bimbingan', 'syarat_seminar', 'bimbingans')
        ->whereHas('proposal', function ($query) {
            $query->where('status', 'done');
        })
        ->withCount(['bimbingans as total_bimbingans' => function ($query) {
            $query->where('status', 'done');
        }])
        ->having('total_bimbingans', '>=', 7)
        ->get();
    
        $pengujis = User::whereHas('roles', function($query){
            $query->where('name','pembimbing');
        })->get();
        $data['kps'] = $kps;
        $data['pengujis'] = $pengujis;
    
        // dd($data);
        return view('admin.syaratSeminar', $data);
    }
    
    public function updateSyaratSeminar(Request $request, string $id) {
        $field = array_keys($request->all())[0];
        
        // Validate if the field is 'tanggal' to ensure it is a date after today
        if ($field === 'tanggal') {
            $validator = Validator::make($request->all(), [
                'tanggal' => 'required|date|after:today',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        }
    
        try {
            $kp = KP::with('syarat_seminar')->findOrFail($id);
            $value = $request->input($field);
    
            $kp->syarat_seminar->update([
                $field => $value,
            ]);
            
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exception
            return response()->json(['message' => 'Failed to update data', 'error' => $e->getMessage()], 500);
        }
    }
    

    public function userLists(){
        $mahasiswas = User::whereHas('roles', function($query){
            $query->where('name', 'mahasiswa');
        })->get();
        
        $pembimbings = User::with('grup_bimbingan')->whereHas('roles', function($query){
            $query->where('name','pembimbing');
        })->get();
        
        foreach ($pembimbings as $pembimbing) {
            $pembimbing->kpCount = KP::where('pembimbing_id', $pembimbing->id)
                ->whereYear('created_at', now()->year)
                ->count();
        }
        
        $data['mahasiswas'] = $mahasiswas;
        $data['pembimbings'] = $pembimbings;
    
        return view('admin.userLists', $data);
    }
}
