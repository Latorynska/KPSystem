<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use PDF;
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
                $query->where(function ($q) {
                    $q->where('pembimbing_id', auth()->id())
                      ->orWhere('penguji_id', auth()->id());
                });
            })
            ->when(auth()->user()->hasRole('pembimbing_lapangan'), function ($query) {
                return $query->where('pembimbing_lapangan_id', auth()->id());
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
    public function nilaiPembimbing(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'pemahaman_masalah' => 'required|integer|between:1,9',
            'deskripsi_solusi' => 'required|integer|between:1,9',
            'percaya_diri' => 'required|integer|between:1,9',
            'tata_tulis' => 'required|integer|between:1,9',
            'pembuktian_produk' => 'required|integer|between:1,9',
            'efektivitas_produk' => 'required|integer|between:1,9',
            'kontribusi' => 'required|integer|between:1,9',
            'originalitas' => 'required|integer|between:1,9',
            'kemudahan_produk' => 'required|integer|between:1,9',
            'peningkatan_kinerja' => 'required|integer|between:1,9'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $kp = KP::with('penilaian','penilaian.nilai_pembimbing')->findOrFail($id);
        try {
            $nilaiPembimbing = $kp->penilaian->nilai_pembimbing;
            if ($nilaiPembimbing) {
                $nilaiPembimbing->update([
                    'pemahaman_masalah' => $request->pemahaman_masalah,
                    'deskripsi_solusi' => $request->deskripsi_solusi,
                    'percaya_diri' => $request->percaya_diri,
                    'tata_tulis' => $request->tata_tulis,
                    'pembuktian_produk' => $request->pembuktian_produk,
                    'efektivitas_produk' => $request->efektivitas_produk,
                    'kontribusi' => $request->kontribusi,
                    'originalitas' => $request->originalitas,
                    'kemudahan_produk' => $request->kemudahan_produk,
                    'peningkatan_kinerja' => $request->peningkatan_kinerja
                ]);
            } else {
                $kp->penilaian->nilai_pembimbing()->create([
                    'pemahaman_masalah' => $request->pemahaman_masalah,
                    'deskripsi_solusi' => $request->deskripsi_solusi,
                    'percaya_diri' => $request->percaya_diri,
                    'tata_tulis' => $request->tata_tulis,
                    'pembuktian_produk' => $request->pembuktian_produk,
                    'efektivitas_produk' => $request->efektivitas_produk,
                    'kontribusi' => $request->kontribusi,
                    'originalitas' => $request->originalitas,
                    'kemudahan_produk' => $request->kemudahan_produk,
                    'peningkatan_kinerja' => $request->peningkatan_kinerja
                ]);
            }

            return response()->json(['message' => 'Nilai pembimbing berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function nilaiPenguji(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'pemahaman_masalah' => 'required|integer|between:1,9',
            'deskripsi_solusi' => 'required|integer|between:1,9',
            'percaya_diri' => 'required|integer|between:1,9',
            'tata_tulis' => 'required|integer|between:1,9',
            'pembuktian_produk' => 'required|integer|between:1,9',
            'efektivitas_produk' => 'required|integer|between:1,9',
            'kontribusi' => 'required|integer|between:1,9',
            'originalitas' => 'required|integer|between:1,9',
            'kemudahan_produk' => 'required|integer|between:1,9',
            'peningkatan_kinerja' => 'required|integer|between:1,9'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $kp = KP::with('penilaian','penilaian.nilai_penguji')->findOrFail($id);
        try {
            $nilaiPenguji = $kp->penilaian->nilai_penguji;
            if ($nilaiPenguji) {
                $nilaiPenguji->update([
                    'pemahaman_masalah' => $request->pemahaman_masalah,
                    'deskripsi_solusi' => $request->deskripsi_solusi,
                    'percaya_diri' => $request->percaya_diri,
                    'tata_tulis' => $request->tata_tulis,
                    'pembuktian_produk' => $request->pembuktian_produk,
                    'efektivitas_produk' => $request->efektivitas_produk,
                    'kontribusi' => $request->kontribusi,
                    'originalitas' => $request->originalitas,
                    'kemudahan_produk' => $request->kemudahan_produk,
                    'peningkatan_kinerja' => $request->peningkatan_kinerja
                ]);
            } else {
                $kp->penilaian->nilai_penguji()->create([
                    'pemahaman_masalah' => $request->pemahaman_masalah,
                    'deskripsi_solusi' => $request->deskripsi_solusi,
                    'percaya_diri' => $request->percaya_diri,
                    'tata_tulis' => $request->tata_tulis,
                    'pembuktian_produk' => $request->pembuktian_produk,
                    'efektivitas_produk' => $request->efektivitas_produk,
                    'kontribusi' => $request->kontribusi,
                    'originalitas' => $request->originalitas,
                    'kemudahan_produk' => $request->kemudahan_produk,
                    'peningkatan_kinerja' => $request->peningkatan_kinerja
                ]);
            }

            return response()->json(['message' => 'Nilai penguji berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function nilaiLapangan(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'kunjungan_mahasiswa' => 'required|integer|between:1,10',
            'pemahaman_masalah' => 'required|integer|between:1,5',
            'kemampuan_penyelesaian' => 'required|integer|between:1,5',
            'keterampilan' => 'required|integer|between:1,5',
            'disiplin' => 'required|integer|between:1,5',
            'teamwork' => 'required|integer|between:1,5',
            'komunikasi' => 'required|integer|between:1,5',
            'sikap_perilaku' => 'required|integer|between:1,5',
            'hasil_solusi' => 'required|integer|between:1,5',
            'kepuasan' => 'required|integer|between:1,5',
            'manfaat' => 'required|integer|between:1,5',
            'peluang_digunakan' => 'required|integer|between:1,5',
            'kemudahan' => 'required|integer|between:1,5',
            'hasil_infrastruktur' => 'required|integer|between:1,5'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $kp = KP::with('penilaian','penilaian.nilai_lapangan')->findOrFail($id);
        try {
            $nilaiLapangan = $kp->penilaian->nilai_lapangan;
            if ($nilaiLapangan) {
                $nilaiLapangan->update([
                    'kunjungan_mahasiswa' => $request->kunjungan_mahasiswa,
                    'pemahaman_masalah' => $request->pemahaman_masalah,
                    'kemampuan_penyelesaian' => $request->kemampuan_penyelesaian,
                    'keterampilan' => $request->keterampilan,
                    'disiplin' => $request->disiplin,
                    'teamwork' => $request->teamwork,
                    'komunikasi' => $request->komunikasi,
                    'sikap_perilaku' => $request->sikap_perilaku,
                    'hasil_solusi' => $request->hasil_solusi,
                    'kepuasan' => $request->kepuasan,
                    'manfaat' => $request->manfaat,
                    'peluang_digunakan' => $request->peluang_digunakan,
                    'kemudahan' => $request->kemudahan,
                    'hasil_infrastruktur' => $request->hasil_infrastruktur
                ]);
            } else {
                $kp->penilaian->nilai_lapangan()->create([
                    'kunjungan_mahasiswa' => $request->kunjungan_mahasiswa,
                    'pemahaman_masalah' => $request->pemahaman_masalah,
                    'kemampuan_penyelesaian' => $request->kemampuan_penyelesaian,
                    'keterampilan' => $request->keterampilan,
                    'disiplin' => $request->disiplin,
                    'teamwork' => $request->teamwork,
                    'komunikasi' => $request->komunikasi,
                    'sikap_perilaku' => $request->sikap_perilaku,
                    'hasil_solusi' => $request->hasil_solusi,
                    'kepuasan' => $request->kepuasan,
                    'manfaat' => $request->manfaat,
                    'peluang_digunakan' => $request->peluang_digunakan,
                    'kemudahan' => $request->kemudahan,
                    'hasil_infrastruktur' => $request->hasil_infrastruktur
                ]);
            }

            return response()->json(['message' => 'Nilai penguji berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cetakNilai(string $id){
        $kp = KP::where('id', $id)->with([
            'mahasiswa', 
            'pembimbing', 
            'penguji', 
            'metadata',
            'penilaian',
            'penilaian.nilai_kordinator',
            'penilaian.nilai_lapangan',
            'penilaian.nilai_penguji',
            'penilaian.nilai_pembimbing',
            'syarat_seminar',
        ])->firstOrFail();
        // $approvalDate = Carbon::parse($proposal->updated_at)->translatedFormat('d F Y');
        $pdf = PDF::loadview('penilaian.lembarPenilaian', compact('kp'))->setPaper('a4','potrait');
        return $pdf->stream('lembar_penilaian.pdf');
    }
}
