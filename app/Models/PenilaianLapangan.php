<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianLapangan extends Model
{
    use HasFactory;
    protected $table = "penilaian_kordinators";
    protected $fillable = [
        'penilaian_id',
        'keaktifan',
        'kunjungan_mahasiswa',
        'pemahaman_masalah',
        'kemampuan_penyelesaian',
        'keterampilan',
        'disiplin',
        'teamwork',
        'komunikasi',
        'sikap_perilaku',
        'hasil_solusi',
        'kepuasan',
        'peluang_digunakan',
        'kemudahan',
        'hasil_infrastruktur'
    ];
}
