<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Excel;

use App\Models\User;
use App\Models\KP;

// use App\Imports\MahasiswaImport;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(){
        return view('mahasiswa.dashboard');
    }
    public function lists()
    {
        $mahasiswa = User::whereHas('roles', function($query){
            $query->where('name','mahasiswa');
        })->get();
        $data['mahasiswas'] = $mahasiswa;
        return view('mahasiswa.lists', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    // import data using api from existing system
    public function synchronizeMahasiswaData()
    {
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

    // import data from excel
    // public function importFromExcel(Request $request){
        
    //     $validator = Validator::make($request->all(), [
    //         'data_file' => 'required|file|mimes:xlsx,xls|max:1024',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
    //     try{
    //         Excel::import(new MahasiswaImport, $request->file('data_file'));
    
    //         return response()->json(['message' => 'Data Synchronized', 'status' => 'ok'], 200);
    //     } catch (\Exception $e) {
    //         dd($e);
    //         return response()->json(['message' => 'failed to upload the data', 'error' => $e->getMessage()], 500);
    //     }
    // }
    public function importFromExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $request->data;
        
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
                }
            }
            return response()->json(['message' => 'Data imported successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
