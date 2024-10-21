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
        Schema::create('penilaian_pembimbings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penilaian_id');
            $table->integer('pemahaman_masalah');
            $table->integer('deskripsi_solusi');
            $table->integer('percaya_diri');
            $table->integer('tata_tulis');
            $table->integer('pembuktian_produk');
            $table->integer('efektivitas_produk');
            $table->integer('kontribusi');
            $table->integer('originalitas');
            $table->integer('kemudahan_produk');
            $table->integer('peningkatan_kinerja');
            $table->timestamps();
            $table->foreign('penilaian_id')->references('id')->on('penilaians')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_pembimbings', function (Blueprint $table) {
            $table->dropForeign(['penilaian_id']);
        });
        Schema::dropIfExists('penilaian_pembimbings');
    }
};
