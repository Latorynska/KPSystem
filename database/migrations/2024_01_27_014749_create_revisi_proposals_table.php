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
        Schema::create('revisi_proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->text('latar_belakang')->nullable();
            $table->text('identifikasi_masalah')->nullable();
            $table->text('rencana_solusi')->nullable();
            $table->text('ruang_lingkup')->nullable();
            $table->text('output_kp')->nullable();
            $table->text('metode_kp')->nullable();
            $table->text('jadwal_pelaksanaan')->nullable();
            $table->text('daftar_pustaka')->nullable();
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('revisi_proposals', function (Blueprint $table) {
            $table->dropForeign(['proposal_id']);
        });
        Schema::dropIfExists('revisi_proposals');
    }
};
