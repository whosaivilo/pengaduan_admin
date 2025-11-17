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
    {Schema::create('media', function (Blueprint $table) {
        $table->id('media_id');
        $table->unsignedBigInteger('pengaduan_id');
        $table->string('path_file');
        $table->string('tipe_file')->nullable();
        $table->timestamps();

        $table->foreign('pengaduan_id')
            ->references('pengaduan_id')
            ->on('pengaduan')
            ->onDelete('cascade');
    });}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
