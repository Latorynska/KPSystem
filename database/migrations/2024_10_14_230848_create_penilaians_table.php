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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kp_id');
            $table->unsignedBigInteger('penguji_id')->nullable();
            $table->unsignedBigInteger('pembimbing_lapangan_id')->nullable();
            $table->timestamps();
            $table->foreign('kp_id')->references('id')->on('kps')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('penguji_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembimbing_lapangan_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropForeign(['kp_id','penguji_id','pembimbiing_lapangan_id']);
        });
        Schema::dropIfExists('penilaians');
    }
};
