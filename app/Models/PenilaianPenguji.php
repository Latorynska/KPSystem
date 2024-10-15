<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianPenguji extends Model
{
    use HasFactory;
    protected $table = "penilaian_kordinators";
    protected $fillable = [
        'penilaian_id',
        'pemahaman_masalah',
        'deskripsi_solusi',
        'percaya_diri',
        'tata_tulis',
        'pembuktian_produk',
        'efektivitas_produk',
        'kontribusi',
        'originalitas',
        'kemudahan_produk',
        'peningkatan_kinerja'
    ];
}
