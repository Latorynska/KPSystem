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
        Schema::create('kps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('pembimbing_id')->nullable();
            $table->unsignedBigInteger('pembimbing_lapangan_id')->nullable();
            $table->unsignedBigInteger('penguji_id')->nullable();
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembimbing_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('penguji_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('pembimbing_lapangan_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kps', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id', 'pembimbing_id','pembimbing_lapangan_id','penguji_id']);
        });
        Schema::dropIfExists('kps');
    }
};
