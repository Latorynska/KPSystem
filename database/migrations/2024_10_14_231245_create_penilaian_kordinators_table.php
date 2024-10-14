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
        Schema::create('penilaian_kordinators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penilaian_id');
            $table->integer('keaktifan');
            $table->integer('laporan');
            $table->integer('bimbingan');
            $table->timestamps();
            $table->foreign('penilaian_id')->references('id')->on('penilaians')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_kordinators', function (Blueprint $table) {
            $table->dropForeign(['penilaian_id']);
        });
        Schema::dropIfExists('penilaian_kordinators');
    }
};
