<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupBimbingan extends Model
{
    use HasFactory;
    protected $table = "grup_bimbingans";
    protected $fillable = ['pembimbing_id','link_grup'];

}
