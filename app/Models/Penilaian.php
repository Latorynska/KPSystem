<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $fillable = ['kp_id','penguji_id','pembimbing_lapangan_id'];

    public function penguji(){
        return $this->belongsTo(User::class, 'penguji_id');
    }
    public function pembimbing_lapangan(){
        return $this->belongsTo(User::class, 'pembimbing_lapangan_id');
    }
    public function nilai_kordinator(){
        return $this->hasOne(PenilaianKordinator::class, 'penilaian_id');
    }

    public function nilai_lapangan(){
        return $this->hasOne(PenilaianLapangan::class, 'penilaian_id');
    }

    public function nilai_penguji(){
        return $this->hasOne(PenilaianPenguji::class, 'penilaian_id');
    }

    public function nilai_pembimbing(){
        return $this->hasOne(PenilaianPembimbing::class, 'penilaian_id');
    }
}
