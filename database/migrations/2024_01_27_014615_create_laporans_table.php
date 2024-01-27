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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kp_id');
            $table->string('file_name',255);
            $table->timestamps();
            $table->foreign('kp_id')->references('id')->on('kps')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropForeign(['kp_id']);
        });
        Schema::dropIfExists('laporans');
    }
};
