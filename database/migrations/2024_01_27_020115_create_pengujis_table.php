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
        Schema::create('pengujis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sidang_id');
            $table->unsignedBigInteger('penguji_id');
            $table->timestamps();

            $table->foreign('sidang_id')->references('id')->on('sidangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('penguji_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengujis', function (Blueprint $table) {
            $table->dropForeign(['sidang_id', 'penguji_id']);
        });
        Schema::dropIfExists('pengujis');
    }
};
