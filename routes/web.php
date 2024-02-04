<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KpController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['role:admin|kordinator']], function () {
    Route::prefix('admin/mahasiswa')
        ->name('admin.mahasiswa')
        ->group(function(){
            Route::get('/', [MahasiswaController::class, 'index']);
            Route::get('/sync', [MahasiswaController::class, 'synchronizeMahasiswaData'])->name('.sync');
        }
    );
    Route::prefix('admin/dosen')
        ->name('admin.dosen')
        ->group(function(){
            Route::get('/', [DosenController::class, 'index']);
            Route::get('/sync', [DosenController::class, 'synchronizePembimbingData'])->name('.sync');
        }
    );
});
Route::group(['middleware' => ['role:kordinator']], function () {
    Route::prefix('kordinator/kp')
        ->name('kordinator.kp')
        ->group(function(){
            Route::get('/details/{id}', [KpController::class, 'details'])->name('.details');
            Route::patch('/details/{id}', [KpController::class, 'assignPembimbing'])->name('.assign');
            Route::get('/proposals', [KpController::class, 'proposals'])->name('.proposals');
            Route::get('/proposal/{id}', [KpController::class, 'proposalDetail'])->name('.proposal');
            Route::post('/proposal/{id}/revisi', [KpController::class, 'revisiProposal'])->name('.revisiProposal');
            Route::get('/lists', [KpController::class, 'lists'])->name('.lists');
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
            Route::get('/suratIzin/{id}', [KpController::class, 'viewSuratIzin'])->name('.suratIzinView');
            Route::post('/proposal', [KpController::class, 'storeProposal'])->name('.proposalPost');
            Route::post('/laporan', [KpController::class, 'storeLaporan'])->name('.laporanPost');
            Route::get('/laporan/{id}', [KpController::class, 'viewLaporan'])->name('.laporanView');
        }
    );
});
Route::group(['middleware' => ['role:mahasiswa|kordinator']], function () {
    Route::prefix('mahasiswa/kp')
        ->name('mahasiswa.kp')
        ->group(function(){
            Route::get('/proposal/{id}', [KpController::class, 'viewProposal'])->name('.proposalView');
        }
    );
});


require __DIR__.'/auth.php';
