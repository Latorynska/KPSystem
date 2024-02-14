<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grup_bimbingans', function (Blueprint $table) {
            $table->id();
            $table->string('link_grup');
            $table->unsignedBigInteger('pembimbing_id');
            $table->timestamps();
            
            $table->foreign('pembimbing_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('grup_bimbingans', function (Blueprint $table) {
            $table->dropForeign('pembimbing_id');
        });
        Schema::dropIfExists('grup_bimbingans');
    }
};
