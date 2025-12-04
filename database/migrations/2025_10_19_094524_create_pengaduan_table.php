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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('pengaduan_id'); // Primary Key
            $table->string('nomor_tiket', 15)->unique();

            // Foreign Key ke tabel 'warga'
            $table->foreignId('warga_id')->constrained('warga', 'warga_id')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_pengaduan', 'kategori_id')->onDelete('cascade');
            // Kolom Lain
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->enum('status', ['Baru', 'Diproses', 'Selesai'])->default('Baru');
            $table->string('lokasi_text', 255);
            $table->string('rt', 3);
            $table->string('rw', 3);



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
