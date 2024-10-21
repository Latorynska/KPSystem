<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianPenguji extends Model
{
    use HasFactory;
    protected $table = "penilaian_pengujis";
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
    public function total_nilai()
    {
        $nilai = [
            $this->pemahaman_masalah,
            $this->deskripsi_solusi,
            $this->percaya_diri,
            $this->tata_tulis,
            $this->pembuktian_produk,
            $this->efektivitas_produk,
            $this->kontribusi,
            $this->originalitas,
            $this->kemudahan_produk,
            $this->peningkatan_kinerja
        ];

        $nilaiValid = array_filter($nilai, fn($value) => !is_null($value));

        return count($nilaiValid) > 0 
            ? array_sum($nilaiValid) / count($nilaiValid) 
            : 0;
    }
    
}
