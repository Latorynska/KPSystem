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
        Schema::create('penilaian_lapangans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penilaian_id');
            $table->integer('kunjungan_mahasiswa');
            $table->integer('pemahaman_masalah');
            $table->integer('kemampuan_penyelesaian');
            $table->integer('keterampilan');
            $table->integer('disiplin');
            $table->integer('teamwork');
            $table->integer('komunikasi');
            $table->integer('sikap_perilaku');
            $table->integer('hasil_solusi');
            $table->integer('kepuasan');
            $table->integer('manfaat');
            $table->integer('peluang_digunakan');
            $table->integer('kemudahan');
            $table->integer('hasil_infrastruktur');
            $table->timestamps();
            $table->foreign('penilaian_id')->references('id')->on('penilaians')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_lapangans', function (Blueprint $table) {
            $table->dropForeign(['penilaian_id']);
        });
        Schema::dropIfExists('penilaian_lapangans');
    }
};
