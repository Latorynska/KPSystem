<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratBimbingan extends Model
{
    use HasFactory;

    protected $table = 'surat_bimbingans';
    protected $fillable = ['file_name','status','status_pengambilan','tanggal_pengambilan','kp_id'];

    public function kp(){
        return $this->belongsTo(KP::class);
    }
}
