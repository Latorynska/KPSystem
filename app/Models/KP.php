<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KP extends Model
{
    use HasFactory;
    
    protected $table = 'kps';
    protected $fillable = ['pembimbing_id','mahasiswa_id'];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    public function metadata()
    {
        return $this->hasOne(KPMetadata::class, 'kp_id');
    }
}
