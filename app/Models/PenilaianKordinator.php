<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKordinator extends Model
{
    use HasFactory;
    protected $table = "penilaian_kordinators";
    protected $fillable = ['penilaian_id','proposal','laporan','bimbingan'];

    public function total_nilai(){
        $nilai = [
            $this->proposal,
            $this->laporan,
            $this->bimbingan,
        ];

        // Hitung rata-rata nilai
        $totalNilai = array_sum($nilai);
        $jumlahKolom = count($nilai);

        return $jumlahKolom > 0 ? $totalNilai / $jumlahKolom : 0.0;
    }
}
