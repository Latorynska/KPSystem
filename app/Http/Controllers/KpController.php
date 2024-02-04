<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\KP;
use App\Models\KPMetadata;
use App\Models\SuratIzin;
use App\Models\Proposal;
use App\Models\RevisiProposal;
use App\Models\Laporan;

class KpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mahasiswa_id = Auth()->id();
        $kp = KP::with('mahasiswa', 'pembimbing', 'metadata')->where('mahasiswa_id',$mahasiswa_id)->firstOrFail();
        $suratIzin = SuratIzin::where('kp_id',$kp->id)->first();
        $proposal = Proposal::where('kp_id',$kp->id)->first();
        $laporan = Laporan::where('kp_id',$kp->id)->first();
        $data['kp'] = $kp;
        $data['suratIzin'] = $suratIzin;
        $data['proposal'] = $proposal;
        $data['laporan'] = $laporan;
        if ($suratIzin) {
            $data['suratIzinFile'] = $suratIzin->file_name;
        }
        if ($proposal) {
            $data['proposalFile'] = $proposal->file_name;
        }
        if ($laporan) {
            $data['laporanFile'] = $laporan->file_name;
        }
        return view('mahasiswa.kp',$data);
    }

    public function lists(){
        $kps = KP::with('mahasiswa', 'pembimbing', 'metadata')->get();
        $data['kps'] = $kps;
        // dd($kps);
        return view('kp.list',$data);
    }

    public function proposals(){
        $proposals = Proposal::with([
            'kp.mahasiswa',
            'kp.metadata',
        ])->get();
        $data['proposals'] = $proposals;
        return view('kp.proposal', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function proposalDetail(string $id)
    {
        $proposal = Proposal::with([
            'kp.mahasiswa',
            'kp.metadata',
        ])->findOrFail($id);
        $filePath = 'Proposal/' . $proposal->file_name;
        $fileUrl = Storage::get($filePath);

        $data['proposal'] = $proposal;
        $data['fileUrl'] = $fileUrl;

        return view('kp.proposalDetail', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function storeSuratIzin(Request $request)
    {
        $request->validate([
            'surat_izin' => 'required|file|mimes:pdf|max:1024',
        ]);
        try {
            $nim = User::findOrFail(Auth()->id())->nomor_induk;
            $kp = KP::where('mahasiswa_id', Auth()->id())->firstOrFail();
            $suratIzin = SuratIzin::where('kp_id', $kp->id)->first();
            if ($request->hasFile('surat_izin')) {
                $file_name = $nim . '_surat_izin.pdf';
                $path = $request->file('surat_izin')->storeAs('SuratIzin', $file_name);
                if ($suratIzin) {
                    $suratIzin->update([
                        'file_name' => $file_name,
                        'file_path' => $path,
                    ]);
                } else {
                    SuratIzin::create([
                        'kp_id' => $kp->id,
                        'file_name' => $file_name,
                        'file_path' => $path,
                    ]);
                }
                $notification = [
                    'message' => 'Surat izin uploaded successfully',
                    'alert-type' => 'success'
                ];
            } else {
                $notification = [
                    'message' => 'Failed to upload surat izin',
                    'alert-type' => 'error'
                ];
            }

            return redirect()->route('mahasiswa.kp')->with($notification);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to store file'], 500);
        }
    }
    public function storeProposal(Request $request)
    {
        $request->validate([
            'proposal' => 'required|file|mimes:pdf|max:1024',
        ]);

        try {
            $nim = User::findOrFail(Auth()->id())->nomor_induk;
            $kp = KP::where('mahasiswa_id', Auth()->id())->firstOrFail();
            $proposal = Proposal::where('kp_id', $kp->id)->first();

            if ($request->hasFile('proposal')) {
                $file_name = $nim . '_proposal.pdf';
                $path = $request->file('proposal')->storeAs('Proposal', $file_name);
                if ($proposal) {
                    $proposal->update([
                        'file_name' => $file_name,
                        'status' => 'awaited',
                    ]);
                } else {
                    Proposal::create([
                        'kp_id' => $kp->id,
                        'file_name' => $file_name,
                        'status' => 'awaited',
                    ]);
                }

                $notification = [
                    'message' => 'Proposal uploaded successfully',
                    'alert-type' => 'success'
                ];
            } else {
                $notification = [
                    'message' => 'Failed to upload proposal',
                    'alert-type' => 'error'
                ];
            }

            return redirect()->route('mahasiswa.kp')->with($notification);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to store file'], 500);
        }
    }
    public function storeLaporan(Request $request){
        $request->validate([
            'laporan' => 'required|file|mimes:pdf|max:1024',
        ]);
        try{
            $nim = User::findOrFail(Auth()->id())->nomor_induk;
        
            $kp = KP::where('mahasiswa_id', Auth()->id())->firstOrFail();
            if ($request->hasFile('laporan')) {
                $file_name = $nim . '_laporan.pdf';
                $path = $request->file('laporan')->storeAs('Laporan', $file_name);
                Laporan::create([
                    'kp_id' => $kp->id,
                    'file_name' => $file_name,
                    'file_path' => $path,
                ]);
        
                $notification = [
                    'message' => 'Surat izin uploaded successfully',
                    'alert-type' => 'success'
                ];
            } else {
                $notification = [
                    'message' => 'Failed to upload surat izin',
                    'alert-type' => 'error'
                ];
            }
            return redirect()->route('mahasiswa.kp')->with($notification);
        } catch(\Exception $e){
            return response()->json(['message' => 'Failed to store file'], 500);
        }
    }

    public function revisiProposal(Request $request, string $id){
        $proposal = Proposal::findOrFail($id);
        try{
            $revisi = RevisiProposal::create([
                'proposal_id' => $proposal->id,
                'latar_belakang' => $request->latar_belakang,
                'identifikasi_masalah' => $request->identifikasi_masalah,
                'rencana_solusi' => $request->rencana_solusi,
                'ruang_lingkup' => $request->ruang_lingkup,
                'output_kp' => $request->output_kp,
                'metode_kp' => $request->metode_kp,
                'jadwal_pelaksanaan' => $request->jadwal_pelaksanaan,
                'daftar_pustaka' => $request->daftar_pustaka,
            ]);
            $proposal->update([
                'status' => 'reviewed',
            ]);
            $notification = [
                'message' => 'Revisi Proposal Berhasil ditambahkan',
                'alert-type' => 'success'
            ];
            return redirect()->route('kordinator.kp.proposals')->with($notification);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['message' => 'Failed to update KP metadata', 'error : ' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    
    public function viewSuratIzin(string $id)
    {
        $suratIzin = SuratIzin::findOrFail($id);
        $filePath = 'SuratIzin/' . $suratIzin->file_name;
        if (Storage::exists($filePath)) {
            $fileContents = Storage::get($filePath);
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $suratIzin->file_name . '"',
            ];
            return response($fileContents, 200)->withHeaders($headers);
                
        } else {
            abort(404, 'File not found');
        }
    }

    public function viewProposal(string $id)
    {
        $proposal = Proposal::findOrFail($id);
        $filePath = 'Proposal/' . $proposal->file_name;
        if (Storage::exists($filePath)) {
            $fileContents = Storage::get($filePath);
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $proposal->file_name . '"',
            ];
            return response($fileContents, 200)->withHeaders($headers);
                
        } else {
            abort(404, 'File not found');
        }
    }

    public function viewLaporan(string $id)
    {
        $laporan = Laporan::findOrFail($id);
        $filePath = 'Laporan/' . $laporan->file_name;
        if (Storage::exists($filePath)) {
            $fileContents = Storage::get($filePath);
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $laporan->file_name . '"',
            ];
            return response($fileContents, 200)->withHeaders($headers);
                
        } else {
            abort(404, 'File not found');
        }
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

    public function patchMetaData(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string',
            'instansi' => 'required|string',
            'nama_pembimbing_lapangan' => 'required|string',
            'nomor_pembimbing_lapangan' => 'required|string|numeric|digits_between:10,15',
        ]);

        try {
            $user_id = Auth()->id();
            $kp = KP::with('metadata')->where('mahasiswa_id', $user_id)->firstOrFail();
            if ($kp->metadata()->exists()) {
                $kp->metadata()->update([
                    'judul' => $request->judul,
                    'instansi' => $request->instansi,
                    'nama_pembimbing_lapangan' => $request->nama_pembimbing_lapangan,
                    'nomor_pembimbing_lapangan' => $request->nomor_pembimbing_lapangan,
                ]);
            } else {
                $metadata = new KPMetadata([
                    'kp_id' => $kp->id,
                    'judul' => $request->judul,
                    'instansi' => $request->instansi,
                    'nama_pembimbing_lapangan' => $request->nama_pembimbing_lapangan,
                    'nomor_pembimbing_lapangan' => $request->nomor_pembimbing_lapangan,
                ]);
                $kp->metadata()->save($metadata);
            }
            
            $notification = [
                'message' => 'Data KP berhasil diperbarui',
                'alert-type' => 'success'
            ];
            return redirect()->route('mahasiswa.kp')->with($notification);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['message' => 'Failed to update KP metadata'], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
