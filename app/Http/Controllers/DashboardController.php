<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        if ($user->hasRole('mahasiswa')) {
            return $this->mahasiswaDashboard();
        } else {
            return $this->defaultDashboard();
        }
    }

    protected function mahasiswaDashboard(){
        return view('mahasiswa.dashboard');
    }
    protected function defaultDashboard(){
        return view('dashboard');
    }
}
