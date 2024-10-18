<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\KpController;
use App\Http\Controllers\PenilaianController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin/suratbimbingan')
        ->name('admin.suratBimbingan')
        ->group(function(){
            Route::get('/', [AdminController::class, 'suratBimbinganIndex']);
            Route::patch('/{id}', [AdminController::class, 'suratBimbinganPengambilan'])->name('.pengambilan');
        }
    );
    Route::prefix('admin/syaratseminar')
        ->name('admin.syaratSeminar')
        ->group(function(){
            Route::get('/', [AdminController::class, 'administratifSeminarIndex']);
            Route::patch('/{id}', [AdminController::class, 'updateSyaratSeminar'])->name('.patch');
        }
    );
    Route::prefix('admin/penilaian')
        ->name('admin.penilaian')
        ->group(function(){
            Route::patch('/{id}', [PenilaianController::class, 'assignPenguji'])->name('.assignPenguji');
        }
    );
});

Route::group(['middleware' => ['role:admin|kordinator']], function () {
    Route::prefix('admin/mahasiswa')
        ->name('admin.mahasiswa')
        ->group(function(){
            Route::get('/', [MahasiswaController::class, 'lists']);
            Route::get('/sync', [MahasiswaController::class, 'synchronizeMahasiswaData'])->name('.sync');
            Route::post('/sync', [MahasiswaController::class, 'importFromExcel'])->name('.import');
            Route::patch('/{id}/reset', [AdminController::class, 'resetMahasiswaPassword'])->name('.password.reset');
        }
    );
    Route::prefix('admin/dosen')
        ->name('admin.dosen')
        ->group(function(){
            Route::get('/', [DosenController::class, 'index']);
            Route::get('/sync', [DosenController::class, 'synchronizePembimbingData'])->name('.sync');
            Route::post('/sync', [DosenController::class, 'importFromExcel'])->name('.import');
            Route::post('/grup/link/{id}', [DosenController::class, 'postLinkGrupBimbingan'])->name('.grup.link.post');
        }
    );
});
Route::group(['middleware' => ['role:kordinator']], function () {
    Route::prefix('kordinator/kp')
        ->name('kordinator.kp')
        ->group(function(){
            Route::get('/juduls', [KpController::class, 'juduls'])->name('.juduls');
            Route::get('/judul/{id}', [KpController::class, 'judulDetail'])->name('.judul');
            Route::patch('/judul/{id}/revisi', [KpController::class, 'revisiJudul'])->name('.judul.revisi');
            Route::patch('/judul/{id}/approve', [KpController::class, 'judulApprove'])->name('.judul.approve');
            Route::patch('/judul/suratizin/{id}/approve', [KpController::class, 'suratIzinApprove'])->name('.suratIzin.approve');
            Route::patch('/judul/suratizin/{id}/revisi', [KpController::class, 'revisiSuratIzin'])->name('.suratIzin.revisi');
            Route::get('/details/{id}', [KpController::class, 'details'])->name('.details');
            Route::patch('/details/{id}', [KpController::class, 'assignPembimbing'])->name('.assign');
            Route::get('/proposals', [KpController::class, 'proposals'])->name('.proposals');
            Route::get('/proposal/{id}', [KpController::class, 'proposalDetail'])->name('.proposal');
            Route::patch('/proposal/{id}', [KpController::class, 'proposalApprove'])->name('.proposal.approve');
            Route::post('/proposal/{id}/revisi', [KpController::class, 'revisiProposal'])->name('.proposal.revisi');
            Route::get('/lists', [KpController::class, 'lists'])->name('.lists');
            
            Route::prefix('/bimbingan')
                ->name('.bimbingan')
                ->group(function(){
                    Route::get('/lists', [BimbinganController::class, 'lists'])->name('.lists');
                    Route::post('/{id}/assign', [BimbinganController::class, 'assignPembimbingLapangan'])->name('.assign');
                }
            );
        }
    );
    Route::prefix('admin/pembimbingLapangan')
        ->name('admin.pembimbingLapangan')
        ->group(function(){
            Route::get('/', [PembimbingController::class, 'lapanganLists']);
            Route::post('/', [PembimbingController::class, 'create'])->name('.create');
        }
    );
});
Route::group(['middleware' => ['role:mahasiswa']], function () {
    Route::prefix('mahasiswa/kp')
        ->name('mahasiswa.kp')
        ->group(function(){
            Route::get('/', [KpController::class, 'index']);
            Route::patch('/metadata', [KpController::class, 'patchMetaData'])->name('.metadata');
            Route::post('/suratIzin', [KpController::class, 'storeSuratIzin'])->name('.suratIzinPost');
            Route::get('/proposal/format', [KpController::class, 'downloadFormatProposal'])->name('.proposal.format');
            Route::post('/proposal', [KpController::class, 'storeProposal'])->name('.proposalPost');
            Route::get('/lembarpengesahan/{id}', [KpController::class, 'downloadLembarPengesahanProposal'])->name('.proposal.lembarPengesahan');
            Route::post('/laporan', [KpController::class, 'storeLaporan'])->name('.laporanPost');
            Route::get('/laporan/{id}', [KpController::class, 'viewLaporan'])->name('.laporanView');
        }
    );
    Route::prefix('mahasiswa/bimbingan')
        ->name('mahasiswa.bimbingan')
        ->group(function(){
            Route::get('/', [MahasiswaController::class, 'bimbingan']);
            Route::post('/create', [BimbinganController::class, 'create'])->name('.create');
            Route::patch('/update/{id}', [BimbinganController::class, 'update'])->name('.update');
        }
    );
});
Route::group(['middleware' => ['role:mahasiswa|kordinator']], function () {
    Route::prefix('mahasiswa/kp')
        ->name('mahasiswa.kp')
        ->group(function(){
            Route::get('/proposal/{id}', [KpController::class, 'viewProposal'])->name('.proposalView');
            Route::get('/suratIzin/{id}', [KpController::class, 'viewSuratIzin'])->name('.suratIzinView');
            Route::get('/laporan/{id}', [KpController::class, 'viewLaporan'])->name('.laporanView');
        }
    );
});
Route::group(['middleware' => ['role:pembimbing']], function () {
    Route::prefix('pembimbing')
        ->name('pembimbing.bimbingan')
        ->group(function(){
            Route::get('/lists', [BimbinganController::class, 'bimbinganList'])->name('.lists');
            Route::get('/lists/details/{id}', [BimbinganController::class, 'details'])->name('.lists.details');
            Route::patch('/bimbingan/approve/{id}', [BimbinganController::class, 'bimbinganApprove'])->name('.approve');
        }
    );
    Route::prefix('pembimbing/bimbingan/lists')
        ->name('pembimbing')
        ->group(function(){
            Route::get('/', [PembimbingController::class, 'lists'])->name('.bimbingan.mahasiswa');
        }
    );
});

Route::group(['middleware' => ['role:kordinator|pembimbing|pembimbing_lapangan']], function () {
    Route::prefix('kp/penilaian')
        ->name('kp.penilaian')
        ->group(function(){
            Route::get('/lists', [PenilaianController::class, 'lists'])->name('.lists');
        }
    );
});

require __DIR__.'/auth.php';
