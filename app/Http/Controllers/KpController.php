<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDF;
use Carbon\Carbon;


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
    public function index(){
        //
        $mahasiswa_id = Auth()->id();
        $kp = KP::with('mahasiswa', 'pembimbing', 'metadata')->where('mahasiswa_id',$mahasiswa_id)->firstOrFail();
        $suratIzin = SuratIzin::where('kp_id',$kp->id)->first();
        $proposal = Proposal::where('kp_id',$kp->id)->with('revisi')->first();
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

    public function juduls(){
        $kps = KP::with('mahasiswa', 'metadata', 'surat_izin')
            ->whereHas('metadata', function ($query) {
                $query->whereNotNull('judul')->where('judul', '!=', '');
            })
            ->get();

        $data['kps'] = $kps;
        return view('kp.judul', $data);
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

    public function judulDetail(string $id){
        $kp = KP::with('mahasiswa', 'metadata')->findOrFail($id);
        $data['kp'] = $kp;
        $suratIzin = SuratIzin::where('kp_id',$kp->id)->first();
        $data['suratIzin'] = $suratIzin;
        return view('kp.judulDetail',$data);
    }
    public function proposalDetail(string $id){
        $proposal = Proposal::with([
            'kp.mahasiswa',
            'kp.metadata',
            'revisi',
        ])->findOrFail($id);

        $pembimbings = User::whereHas('roles', function($query){
            $query->where('name','pembimbing');
        })->get();
        
        foreach ($pembimbings as $pembimbing) {
            $pembimbing->kpCount = KP::where('pembimbing_id', $pembimbing->id)
                ->whereYear('created_at', now()->year)
                ->count();
        }
        
        $filePath = 'Proposal/' . $proposal->file_name;
        $fileUrl = Storage::get($filePath);

        $data['proposal'] = $proposal;
        $data['fileUrl'] = $fileUrl;
        $data['pembimbings'] = $pembimbings;

        return view('kp.proposalDetail', $data);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function storeSuratIzin(Request $request){
        $validator = Validator::make($request->all(), [
            'surat_izin' => 'required|file|mimes:pdf|max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $nim = User::findOrFail(Auth()->id())->nomor_induk;
            $kp = KP::where('mahasiswa_id', Auth()->id())->with('surat_izin')->firstOrFail();
            if ($request->hasFile('surat_izin')) {
                $file_name = $nim . '_surat_izin.pdf';
                $path = $request->file('surat_izin')->storeAs('SuratIzin', $file_name);
                if ($kp->surat_izin) {
                    $kp->surat_izin->update([
                        'file_name' => $file_name,
                        'file_path' => $path,
                        'status' => 'awaited',
                    ]);
                } else {
                    $suratIzin = SuratIzin::create([
                        'kp_id' => $kp->id,
                        'file_name' => $file_name,
                        'file_path' => $path,
                        'status' => 'awaited',
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
    public function storeProposal(Request $request){
        $validator = Validator::make($request->all(), [
            'proposal' => 'required|file|mimes:pdf|max:4096',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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
                        'revisi_count' => $proposal->revisi_count+1,
                    ]);
                } else {
                    Proposal::create([
                        'kp_id' => $kp->id,
                        'file_name' => $file_name,
                        'status' => 'awaited',
                        'revisi_count' => '0',
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
            dd($e);
            return response()->json(['message' => 'Failed to store file'], 500);
        }
    }
    public function storeLaporan(Request $request){
        $validator = Validator::make($request->all(), [
            'laporan' => 'required|file|mimes:pdf|max:4096',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
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
                    'message' => 'Laporan uploaded successfully',
                    'alert-type' => 'success'
                ];
            } else {
                $notification = [
                    'message' => 'Failed to upload laporan',
                    'alert-type' => 'error'
                ];
            }
            return redirect()->route('mahasiswa.bimbingan')->with($notification);
        } catch(\Exception $e){
            return response()->json(['message' => 'Failed to store file'], 500);
        }
    }

    public function revisiJudul(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'pesan_revisi' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $kp = KP::with('metadata')->findOrFail($id);
        try{
            $kp->metadata->update([
                'status' => 'reviewed',
                'pesan_revisi' => $request->pesan_revisi,
            ]);
            $notification = [
                'message' => 'Revisi Judul Berhasil ditambahkan',
                'alert-type' => 'success'
            ];
            return redirect()->route('kordinator.kp.juduls')->with($notification);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update KP metadata', 'error' => $e->getMessage()], 500);
        }
    }

    public function revisiSuratIzin(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'pesan_revisi' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $kp = KP::with('surat_izin')->findOrFail($id);
        try{
            $kp->surat_izin->update([
                'status' => 'reviewed',
                'pesan_revisi' => $request->pesan_revisi,
            ]);
            $notification = [
                'message' => 'Revisi Surat Izin Berhasil ditambahkan',
                'alert-type' => 'success'
            ];
            return redirect()->route('kordinator.kp.juduls')->with($notification);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update KP metadata', 'error' => $e->getMessage()], 500);
        }
    }

    public function revisiProposal(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'judul' => 'nullable|max:255|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
            // 'latar_belakang' => 'nullable|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
            // 'identifikasi_masalah' => 'nullable|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
            // 'rencana_solusi' => 'nullable|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
            // 'ruang_lingkup' => 'nullable|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
            // 'output_kp' => 'nullable|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
            // 'metode_kp' => 'nullable|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
            // 'jadwal_pelaksanaan' => 'nullable|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
            // 'daftar_pustaka' => 'nullable|regex:/^[a-zA-Z0-9@\/\'":,\s\-\n.*\/()+]+$/',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }    
        
        // $request->validate([
        //     'judul' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        //     'latar_belakang' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        //     'identifikasi_masalah' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        //     'rencana_solusi' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        //     'ruang_lingkup' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        //     'output_kp' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        //     'metode_kp' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        //     'jadwal_pelaksanaan' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        //     'daftar_pustaka' => 'nullable|regex:/^[a-zA-Z0-9@\/\'"\-]+$/',
        // ]);

        $proposal = Proposal::findOrFail($id);
        $kp = KP::with('metadata')->findOrFail($proposal->kp_id);
        // dump($proposal);
        // dd($kp);
        try {
            $revisi = RevisiProposal::where('proposal_id', $proposal->id)->first();
            if($request->judul){
                $kp->metadata->update(['judul'=>$request->judul]);
            }
            if ($revisi) {
                $revisi->update([
                    'latar_belakang' => $request->latar_belakang,
                    'identifikasi_masalah' => $request->identifikasi_masalah,
                    'rencana_solusi' => $request->rencana_solusi,
                    'ruang_lingkup' => $request->ruang_lingkup,
                    'output_kp' => $request->output_kp,
                    'metode_kp' => $request->metode_kp,
                    'jadwal_pelaksanaan' => $request->jadwal_pelaksanaan,
                    'daftar_pustaka' => $request->daftar_pustaka,
                ]);
            } else {
                // Create a new revisi proposal
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
            }

            // Update the status of the proposal
            $proposal->update([
                'status' => 'reviewed',
            ]);

            $notification = [
                'message' => 'Revisi Proposal Berhasil ditambahkan',
                'alert-type' => 'success'
            ];

            return redirect()->route('kordinator.kp.proposals')->with($notification);
        } catch (\Exception $e) {
            // Handle exception
            dd($e);
            return response()->json(['message' => 'Failed to update KP metadata', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function details(string $id){
        $kp = KP::with('mahasiswa', 'pembimbing', 'metadata', 'surat_izin')->findOrFail($id);
        $pembimbings = User::whereHas('roles', function($query){
            $query->where('name','pembimbing');
        })->get();
        foreach ($pembimbings as $pembimbing) {
            $pembimbing->kpCount = KP::where('pembimbing_id', $pembimbing->id)->count();
        }
        $suratIzin = SuratIzin::where('kp_id',$kp->id)->first();
        $proposal = Proposal::where('kp_id',$kp->id)->first();
        $laporan = Laporan::where('kp_id',$kp->id)->first();
        $data['suratIzin'] = $suratIzin;
        $data['proposal'] = $proposal;
        $data['laporan'] = $laporan;
        $data['kp'] = $kp;
        $data['pembimbings'] = $pembimbings;
        return view('kp.index',$data);
    }
    
    public function viewSuratIzin(string $id){
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
    public function viewProposal(string $id){
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
    public function viewLaporan(string $id){
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

    public function downloadLembarPengesahanProposal(string $id){
        $user = User::findOrFail($id);
        $kp = KP::where('mahasiswa_id', $id)->with(['mahasiswa', 'pembimbing', 'metadata'])->firstOrFail();
        $proposal = Proposal::where('kp_id', $kp->id)->firstOrFail();
        $approvalDate = Carbon::parse($proposal->updated_at)->translatedFormat('d F Y');
        if ($proposal->status != 'done') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $pdf = PDF::loadview('kp.lembarPengesahan', compact('kp', 'proposal', 'user','approvalDate'));
        return $pdf->stream('lembar_pengesahan.pdf');
    }

    public function downloadFormatProposal(){
        $filePath = public_path('storage/ContohFormatProposal.docx');
        if (file_exists($filePath)) {
            return response()->download($filePath, "Format Proposal KP.docx");
        } else {
            return response()->json(['message' => 'File not found.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function assignPembimbing(Request $request, string $id){
        $kp = KP::findOrFail($id);
        $request->validate([
            'pembimbing_id' => 'required'
        ]);
        try{
            $kp->update([
                'pembimbing_id' => $request->pembimbing_id,
            ]);
            $notification = [
                'message' => 'Data KP berhasil diperbarui',
                'alert-type' => 'success'
            ];
            return redirect()->route('kordinator.kp.lists')->with($notification);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['message' => 'Failed to update KP data','error : ' => $e], 500);
        }
    }

    public function judulApprove(string $id){
        $kp = KP::with('metadata')->findOrFail($id);
        try{
            $kp->metadata->update(['status' => 'done']); 
            
            $notification = [
                'message' => 'Judul KP berhasil disetujui',
                'alert-type' => 'success'
            ];
            return redirect()->route('kordinator.kp.juduls')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Failed to update Judul status','error : ' => $e], 500);
        }
    }
    public function suratIzinApprove(string $id){
        $suratIzin = SuratIzin::findOrFail($id);
        try{
            $suratIzin->update(['status' => 'done']); 
            
            $notification = [
                'message' => 'Surat izin berhasil disetujui',
                'alert-type' => 'success'
            ];
            return redirect()->route('kordinator.kp.juduls')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Failed to update surat izin status','error : ' => $e], 500);
        }
    }
    public function proposalApprove(string $id){
        $proposal = Proposal::findOrFail($id);
        try{
            $proposal->update([
                'status' => 'done',
            ]);
            
            $notification = [
                'message' => 'Proposal berhasil disetujui',
                'alert-type' => 'success'
            ];
            // dd($proposal);
            return redirect()->route('kordinator.kp.proposals')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Failed to update proposal data','error : ' => $e], 500);
        }
    }

    public function patchMetaData(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'instansi' => 'required|string',
            'nama_pembimbing_lapangan' => 'required|string',
            'nomor_pembimbing_lapangan' => 'required|string|numeric|digits_between:10,15',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $user_id = Auth()->id();
            $kp = KP::with('metadata')->where('mahasiswa_id', $user_id)->firstOrFail();
            if ($kp->metadata()->exists()) {
                if($kp->metadata->status == 'reviewed' && $request->status != 'reviewed'){
                    return response()->json(['message' => "Judul anda sudah diulas oleh kordinator, Silahkan muat ulang halaman terlebih dahulu"], 409);
                }
                $kp->metadata()->update([
                    'judul' => $request->judul,
                    'instansi' => $request->instansi,
                    'nama_pembimbing_lapangan' => $request->nama_pembimbing_lapangan,
                    'nomor_pembimbing_lapangan' => $request->nomor_pembimbing_lapangan,
                    'status' => 'awaited',
                ]);
            } else {
                $metadata = new KPMetadata([
                    'kp_id' => $kp->id,
                    'judul' => $request->judul,
                    'instansi' => $request->instansi,
                    'nama_pembimbing_lapangan' => $request->nama_pembimbing_lapangan,
                    'nomor_pembimbing_lapangan' => $request->nomor_pembimbing_lapangan,
                    'status' => 'awaited',
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
            return response()->json(['message' => 'Failed to update KP metadata', 'error' => $e], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
}
