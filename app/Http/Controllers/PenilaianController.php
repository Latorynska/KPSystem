<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\KP;
use App\Models\KPMetadata;
use App\Models\Laporan;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    //
    public function lists() {
        $kps = KP::with([
                'mahasiswa',
                'pembimbing',
                'metadata',
                'penilaian',
                'penilaian.penguji',
                'penilaian.nilaiKordinator',
                'penilaian.nilaiLapangan',
                'penilaian.nilaiPenguji',
                'penilaian.nilaiPembimbing',
                'syarat_seminar'
            ])
            ->whereHas('penilaian', function ($query) {
                $query->whereNotNull('penguji_id');
            })
            ->when(auth()->user()->hasRole('pembimbing'), function ($query) {
                return $query->where('pembimbing_id', auth()->id());
            })
            ->when(auth()->user()->hasRole('kordinator'), function ($query) {
                return $query;
            })
            ->get();
    
        $data['kps'] = $kps;
        return view('penilaian.lists', $data);
    }    

    public function assignPenguji(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'penguji_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $penilaian = Penilaian::where('kp_id', $id)->firstOrFail();

        try{
            $penilaian->update([
                'penguji_id' => $request->penguji_id
            ]);
            return response()->json(['message' => 'Penguji berhasil dipilih'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
