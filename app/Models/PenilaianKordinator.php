<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKordinator extends Model
{
    use HasFactory;
    protected $table = "penilaian_kordinators";
    protected $fillable = ['penilaian_id','proposal','laporan','bimbingan'];
}
