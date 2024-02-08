<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $fillable = ['kp_id','file_name','status','revisi_count'];

    public function kp(){
        return $this->belongsTo(KP::class);
    }
    public function revisi(){
        return $this->hasOne(RevisiProposal::class);
    }
}
