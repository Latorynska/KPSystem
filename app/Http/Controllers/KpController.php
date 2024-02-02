<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KP;
use App\Models\KPMetadata;

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
        $data['kp'] = $kp;
        return view('kp.index',$data);
    }

    public function lists(){
        $kps = KP::with('mahasiswa', 'pembimbing', 'metadata')->get();
        $data['kps'] = $kps;
        // dd($kps);
        return view('kp.list',$data);
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
            return redirect()->route('mahasiswa.kp')->with($notification);
        } catch (\Exception $e) {
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
