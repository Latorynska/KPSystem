<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


use App\Models\KP;
use App\Models\KPMetadata;
use App\Models\Proposal;

class DashboardController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        if ($user->hasRole('mahasiswa')) {
            return $this->mahasiswaDashboard();
        }
        else if ($user->hasRole('kordinator')) {
            return $this->kordinatorDashboard();
        } else {
            return $this->defaultDashboard();
        }
    }

    protected function mahasiswaDashboard(){
        $oneYearAgo = Carbon::now()->subYear();

        $kps = KP::with('mahasiswa', 'metadata')
            ->whereHas('metadata', function ($query) {
                $query->where('status', 'done');
            })
            ->whereHas('metadata', function ($query) use ($oneYearAgo) {
                $query->where('updated_at', '>=', $oneYearAgo);
            })
            ->get();
        foreach($kps as $kp){
            $kp->approvalDate = Carbon::parse($kp->metadata->updated_at)->translatedFormat('d F Y');
        }

        $data['kps'] = $kps;
        return view('mahasiswa.dashboard', $data);
    }

    protected function kordinatorDashboard(){
        $kp_awaited_count = KPMetadata::where('status', 'awaited')
            ->whereNotNull('judul')
            ->count();
        $proposal_awaited_count = Proposal::where('status','awaited')->count();
        $data = [
            'kp_awaited_count' => $kp_awaited_count,
            'proposal_awaited_count' => $proposal_awaited_count,
        ];
        return view('kordinator.dashboard',$data);
    }

    protected function defaultDashboard(){
        return view('dashboard');
    }
}
