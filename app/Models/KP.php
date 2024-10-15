<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KP extends Model
{
    use HasFactory;
    
    protected $table = 'kps';
    protected $fillable = ['pembimbing_id','mahasiswa_id','pembimbing_lapangan_id'];

    public function mahasiswa(){
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function pembimbing(){
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    public function metadata(){
        return $this->hasOne(KPMetadata::class, 'kp_id');
    }

    public function proposal(){
        return $this->hasOne(Proposal::class, 'kp_id');   
    }

    public function surat_izin(){
        return $this->hasOne(SuratIzin::class, 'kp_id');   
    }

    public function surat_bimbingan(){
        return $this->hasOne(SuratBimbingan::class, 'kp_id');
    }

    public function laporan(){
        return $this->hasOne(Laporan::class, 'kp_id');
    }

    public function bimbingans(){
        return $this->hasMany(Bimbingan::class, 'kp_id');
    }

    public function syarat_seminar(){
        return $this->hasOne(SyaratSeminar::class, 'kp_id');
    }

    public function penilaian(){
        return $this->hasOne(Penilaian::class, 'kp_id');
    }
    
    // public function pembimbing_lapangan()
    // {
    //     return $this->belongsTo(User::class, 'pembimbing_lapangan_id');
    // }
}
