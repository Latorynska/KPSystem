<?php

namespace App\Imports;

use App\Models\User;
use App\Models\KP;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $row = array_filter($row, function ($value) {
            return $value !== null && $value !== '';
        });
    
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
            return $newUser;
        }
        return null;
    }
}
