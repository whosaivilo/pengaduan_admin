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
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->id('tindak_id'); // PK
                                     // FK ke pengaduan
            $table->foreignId('pengaduan_id')->constrained('pengaduan', 'pengaduan_id')->onDelete('cascade');

            $table->string('petugas', 100); // Admin yang melakukan aksi
            $table->text('aksi');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut');
    }
};
