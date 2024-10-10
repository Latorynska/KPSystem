<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratSeminar extends Model
{
    use HasFactory;
    protected $table = 'syarat_seminars';
    protected $primaryKey = 'kp_id';
    protected $fillable = ['laporan_kp','lembar_pengesahan','bebas_tunggakan','bebas_pinjaman', 'tanggal'];
    
}
