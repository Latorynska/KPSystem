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
    
    public function nilaiAkhir(): float
    {
        // Ambil semua nilai kolom yang diperlukan
        $nilai = [
            $this->keaktifan,
            $this->kunjungan_mahasiswa,
            $this->pemahaman_masalah,
            $this->kemampuan_penyelesaian,
            $this->keterampilan,
            $this->disiplin,
            $this->teamwork,
            $this->komunikasi,
            $this->sikap_perilaku,
            $this->hasil_solusi,
            $this->kepuasan,
            $this->peluang_digunakan,
            $this->kemudahan,
            $this->hasil_infrastruktur,
        ];

        // Hitung rata-rata nilai
        $totalNilai = array_sum($nilai);
        $jumlahKolom = count($nilai);

        return $jumlahKolom > 0 ? $totalNilai / $jumlahKolom : 0.0;
    }
}
