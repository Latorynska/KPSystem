<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Excel;

use App\Models\User;
use App\Models\KP;
use App\Models\KPMetadata;
use App\Models\SyaratSeminar;
use App\Models\Penilaian;


// use App\Imports\MahasiswaImport;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(){
        return view('mahasiswa.dashboard');
    }
    public function lists(){
        $mahasiswa = User::whereHas('roles', function($query){
            $query->where('name','mahasiswa');
        })->get();
        $data['mahasiswas'] = $mahasiswa;
        return view('mahasiswa.lists', $data);
    }

    // import data using api from existing system
    public function synchronizeMahasiswaData(){
        // waiting for API to consume, so this feature is turned off
        return response()->json(['message' => 'Fitur dalam pengembangan, tidak bisa digunakan'], 500);
        // try {
        //     $response = Http::get('https://65b8cab8b71048505a897656.mockapi.io/MahasiswaList');
        //     $mahasiswaList = $response->json();
        //     foreach ($mahasiswaList as $mahasiswa) {
        //         $existingUser = User::where('nomor_induk', $mahasiswa['NIM'])->first();
        //         if (!$existingUser) {
        //             $newUser = User::create([
        //                 'name' => $mahasiswa['nama'],
        //                 'email' => $mahasiswa['email'],
        //                 'nomor_induk' => $mahasiswa['NIM'],
        //                 'password' => Hash::make('Password123'),
        //             ]);
        //             $newUser->assignRole('mahasiswa');
                    
        //             $kpData = new KP();
        //             $kpData->mahasiswa_id = $newUser->id;
        //             $kpData->save();
        //         }
        //     }

        //     return response()->json(['message' => 'Data Synchronized', 'status' => 'ok'], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }
    }

    public function importFromExcel(Request $request){
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $request->data;
        $requiredFields = ['nim', 'nama', 'email'];
        $firstRow = reset($data);
        $firstRowKeys = array_map('strtolower', array_keys($firstRow));
    
        foreach ($requiredFields as $field) {
            if (!in_array($field, $firstRowKeys)) {
                return response()->json(['errors' => 'File invalid: missing required columns.'], 422);
            }
        }
        
        try {
            foreach ($data as $row) {
                $row = array_change_key_case($row, CASE_LOWER);
                if (empty($row['nim']) || empty($row['nama']) || empty($row['email'])) {
                    continue;
                }
                $existingUser = User::where('nomor_induk', $row['nim'])->first();

                if (!$existingUser) {
                    $newUser = User::create([
                        'nomor_induk' => $row['nim'],
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'password' => Hash::make('Password123'),
                    ]);
                    $newUser->assignRole('mahasiswa');
                    $kpData = new KP();
                    $kpData->mahasiswa_id = $newUser->id;
                    $kpData->save();
                    $metaData = new KPMetadata();
                    $metaData->kp_id = $kpData->id;
                    $metaData->save();
                    $syaratSeminar = new SyaratSeminar();
                    $syaratSeminar->kp_id = $kpData->id;
                    $syaratSeminar->save();
                    $penilaian = new Penilaian();
                    $penilaian->kp_id = $kpData->id;
                    $penilaian->save();
                }
            }
            return response()->json(['message' => 'Data imported successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function bimbingan(){
        $mahasiswa_id = auth()->id();
        $kp = KP::with('bimbingans', 'pembimbing.grup_bimbingan', 'surat_bimbingan','laporan')
                ->where('mahasiswa_id', $mahasiswa_id)
                ->firstOrFail();

        // $dosenBimbingans = $kp->bimbingans->where('tipe', 'dosen');
        // $lapanganBimbingans = $kp->bimbingans->where('tipe', 'lapangan');

        $data['kp'] = $kp;
        // $data['dosenBimbingans'] = $dosenBimbingans;
        // $data['lapanganBimbingans'] = $lapanganBimbingans;

        return view('mahasiswa.bimbingan', $data);
    }
}
