<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DosenController extends Controller
{
    //
    
    public function index()
    {
        $pembimbings = User::whereHas('roles', function($query){
            $query->where('name','pembimbing');
        })->get();
        $data['pembimbings'] = $pembimbings;
        return view('dosen.index', $data);
    }

    public function synchronizePembimbingData()
    {
        try {
            // Fetch JSON data from the API
            $response = Http::get('https://65b8cab8b71048505a897656.mockapi.io/DosenList');
            $pembimbingList = $response->json();
            foreach ($pembimbingList as $pembimbing) {
                // dd($pembimbing);
                $existingUser = User::where('nomor_induk', $pembimbing['NIDN'])->first();
                if (!$existingUser) {
                    $newUser = User::create([
                        'name' => $pembimbing['nama'],
                        'email' => $pembimbing['email'],
                        'nomor_induk' => $pembimbing['NIDN'],
                        'password' => Hash::make('Password123'),
                    ]);
                    
                    $newUser->assignRole('pembimbing');
                }
            }
            return response()->json(['message' => 'Data Synchronized', 'status' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
