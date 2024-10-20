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
                'pembimbing_lapangan',
                'penguji',
                'metadata',
                'penilaian',
                'penilaian.nilai_kordinator',
                'penilaian.nilai_lapangan',
                'penilaian.nilai_penguji',
                'penilaian.nilai_pembimbing',
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
        if(Auth()->user()->hasRole('kordinator')){
            $pembimbingLapangans = User::whereHas('roles', function($query){
                $query->where('name','pembimbing_lapangan');
            })->get();
            $pembimbings = User::whereHas('roles', function($query){
                $query->where('name','pembimbing');
            })->get();
            $data['pembimbingLapangans'] = $pembimbingLapangans;
            $data['pembimbings'] = $pembimbings;
        }
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
        try{
            $kp = KP::findOrFail($id);
            $kp->update([
                'penguji_id' => $request->penguji_id
            ]);
            return response()->json(['message' => 'Penguji berhasil dipilih'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function nilaiKordinator(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'proposal' => 'required|integer|between:1,10',
            'bimbingan' => 'required|integer|between:1,10',
            'laporan' => 'required|integer|between:1,10',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $kp = KP::with('penilaian','penilaian.nilai_kordinator')->findOrFail($id);
        try {
            $nilaiKordinator = $kp->penilaian->nilai_kordinator;
            if ($nilaiKordinator) {
                $nilaiKordinator->update([
                    'proposal' => $request->proposal,
                    'bimbingan' => $request->bimbingan,
                    'laporan' => $request->laporan,
                ]);
            } else {
                $kp->penilaian->nilai_kordinator()->create([
                    'penilaian_id' => $kp->penilaian->id,
                    'proposal' => $request->proposal,
                    'bimbingan' => $request->bimbingan,
                    'laporan' => $request->laporan,
                ]);
            }

            return response()->json(['message' => 'Nilai kordinator berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
