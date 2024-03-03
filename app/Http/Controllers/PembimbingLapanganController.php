<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class PembimbingLapanganController extends Controller
{
    // view all pembimbing lapangan in
    public function lists(){
        $pembimbingLapangans = User::whereHas('roles', function($query){
            $query->where('name','pembimbing_lapangan');
        })->get();
        $data['pembimbingLapangans'] = $pembimbingLapangans;
        return view('pembimbingLapangan.lists',$data);
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
        // return response()->json(['message' => 'data received'], 500);
        try{
            $existingUser = User::where('nomor_induk', $request->nomor_induk)->first();
            if($existingUser){
                return response()->json(['message' => "Nomor Induk Sudah digunakan, silahkan gunakan nomor identitas lain"], 409);
            } else {
                $newPembimbingLapangan = User::create([
                    'nomor_induk' => $request->nomor_induk,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make('Password123'),
                ]);
                $newPembimbingLapangan->assignRole('pembimbing_lapangan');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Failed to store file'], 500);
        }
    }
}
