<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\KP;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(){
        return view('mahasiswa.dashboard');
    }
    public function index()
    {
        $mahasiswa = User::whereHas('roles', function($query){
            $query->where('name','mahasiswa');
        })->get();
        $data['mahasiswas'] = $mahasiswa;
        return view('mahasiswa.index', $data);
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
        try {
            // Fetch JSON data from the API
            $response = Http::get('https://65b8cab8b71048505a897656.mockapi.io/MahasiswaList');
            $mahasiswaList = $response->json();
            foreach ($mahasiswaList as $mahasiswa) {
                // dd($mahasiswa);
                $existingUser = User::where('nomor_induk', $mahasiswa['NIM'])->first();
                // dd($existingUser);
                if (!$existingUser) {
                    // dd($mahasiswa);
                    $newUser = User::create([
                        'name' => $mahasiswa['nama'],
                        'email' => $mahasiswa['email'],
                        'nomor_induk' => $mahasiswa['NIM'],
                        'password' => Hash::make('Password123'),
                    ]);
                    // dd($newUser);
                    
                    $newUser->assignRole('mahasiswa');
                    // dd('assigned');
                    
                    $kpData = new KP();
                    $kpData->mahasiswa_id = $newUser->id;
                    $kpData->save();
                }
            }
            // return response()->json($response->json(), 200);

            return response()->json(['message' => 'Data Synchronized', 'status' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
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
