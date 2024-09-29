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
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kp_id');
            $table->text('isi');
            $table->datetime('tanggal');
            // $table->enum('tipe',['dosen','lapangan']);
            $table->enum('status', ['done', 'awaited', 'reviewed']);
            // $table->string('file_bukti',255)->nullable();
            $table->timestamps();
            $table->foreign('kp_id')->references('id')->on('kps')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bimbingans', function (Blueprint $table) {
            $table->dropForeign(['kp_id']);
        });
        Schema::dropIfExists('bimbingans');
    }
};
