<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPMetadata extends Model
{
    use HasFactory;
    protected $table = "kp_metadatas";
    protected $fillable = ['kp_id','judul','instansi','nama_pembimbing_lapangan','nomor_pembimbing_lapangan','status'];
}
