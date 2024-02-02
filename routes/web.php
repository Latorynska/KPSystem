<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
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

Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin/mahasiswa')
        ->name('admin.mahasiswa')
        ->group(function(){
            Route::get('/', [MahasiswaController::class, 'index']);
            Route::get('/sync', [MahasiswaController::class, 'synchronizeMahasiswaData'])->name('.sync');
        }
    );
    Route::prefix('admin/kp')
        ->name('admin.kp')
        ->group(function(){
            Route::get('/lists', [KpController::class, 'lists'])->name('.lists');
        }
    );
});
Route::group(['middleware' => ['role:mahasiswa']], function () {
    Route::prefix('mahasiswa/kp')
        ->name('mahasiswa.kp')
        ->group(function(){
            Route::get('/', [KpController::class, 'index']);
            Route::patch('/', [KpController::class, 'patchMetaData'])->name('.metadata');

        }
    );
});



require __DIR__.'/auth.php';
