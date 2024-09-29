<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;
    // protected $fillable = ['kp_id','isi','tanggal','status','tipe'];
    protected $fillable = ['kp_id','isi','tanggal','status'];
}
