<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Excel;

use App\Models\User;
use App\Models\KP;
use App\Models\GrupBimbingan;

// use App\Imports\DosenImport;


class DosenController extends Controller
{
    //
    // view
    public function index(){
        $pembimbings = User::with('grup_bimbingan')->whereHas('roles', function($query){
            $query->where('name','pembimbing');
        })->get();
        
        foreach ($pembimbings as $pembimbing) {
            $pembimbing->kpCount = KP::where('pembimbing_id', $pembimbing->id)
                ->whereYear('created_at', now()->year)
                ->count();
        }
        $data['pembimbings'] = $pembimbings;
        return view('dosen.lists', $data);
    }

    // transaction
    public function synchronizePembimbingData(){
        // waiting for API to consume, so this feature is turned off
        return response()->json(['message' => 'Fitur dalam pengembangan, tidak bisa digunakan'], 500);
        // try {
        //     // Fetch JSON data from the API
        //     $response = Http::get('https://65b8cab8b71048505a897656.mockapi.io/DosenList');
        //     $pembimbingList = $response->json();
        //     foreach ($pembimbingList as $pembimbing) {
        //         $existingUser = User::where('nomor_induk', $pembimbing['NIDN'])->first();
        //         if (!$existingUser) {
        //             $newUser = User::create([
        //                 'name' => $pembimbing['nama'],
        //                 'email' => $pembimbing['email'],
        //                 'nomor_induk' => $pembimbing['NIDN'],
        //                 'password' => Hash::make('Password123'),
        //             ]);
                    
        //             $newUser->assignRole('pembimbing');
        //         }
        //     }
        //     return response()->json(['message' => 'Data Synchronized', 'status' => 'ok'], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e], 500);
        // }
    }

    // public function importFromExcel(Request $request){
    //     $request->validate([
    //         'data_file' => 'required|max:10000|mimes:xlsx,xls',
    //     ]);
    //     try{
    //         Excel::import(new DosenImport, $request->file('data_file'));

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
                if (empty($row['nidn']) || empty($row['nama']) || empty($row['email'])) {
                    continue;
                }
                $existingUser = User::where('nomor_induk', $row['nidn'])->first();

                if (!$existingUser) {
                    $newUser = User::create([
                        'nomor_induk' => $row['nidn'],
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'password' => Hash::make('Password123'),
                    ]);
                    $newUser->assignRole('pembimbing');
                }
            }
            return response()->json(['message' => 'Data imported successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postLinkGrupBimbingan(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'link_grup' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pembimbing = User::with('grup_bimbingan')->findOrFail($id);

        try{
            if($pembimbing->grup_bimbingan){
                $pembimbing->grup_bimbingan->update([
                    'link_grup' => $request->link_grup,
                ]);
            } else {
                GrupBimbingan::create([
                    'pembimbing_id' => $id,
                    'link_grup' => $request->link_grup,
                ]);
            }
            return response()->json(['message' => 'Link Grup Bimbingan sudah diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }

    }
}
