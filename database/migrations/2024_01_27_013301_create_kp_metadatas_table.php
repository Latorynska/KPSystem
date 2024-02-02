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
        Schema::create('kp_metadatas', function (Blueprint $table) {
            $table->foreignId('kp_id')->constrained('kps');
            $table->string('judul', 255);
            $table->string('instansi', 255);
            $table->string('nama_pembimbing_lapangan', 100);
            $table->string('nomor_pembimbing_lapangan', 15);
            $table->timestamps();
            
            $table->primary('kp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kp_metadatas', function (Blueprint $table) {
            $table->dropForeign(['kp_id']);
        });
        Schema::dropIfExists('kp_metadatas');
    }
};
