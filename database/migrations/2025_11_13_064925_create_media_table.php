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
        Schema::create('media', function (Blueprint $table)
        {
            $table->id('media_id');

            // 'ref_table' akan menyimpan nama model/tabel (e.g., 'Pengaduan', 'Berita')
            // 'ref_id' akan menyimpan ID dari record di tabel tersebut
            $table->string('ref_table', 50)->comment('Nama tabel yang direferensi');
            $table->unsignedBigInteger('ref_id')->comment('ID dari record yang direferensi');
            $table->index(['ref_table', 'ref_id']);


            // --- KOLOM FILE ---
            $table->string('file_name', 255)->comment('Nama file di storage'); // Menggantikan path_file
            $table->string('caption', 255)->nullable(); // Kolom caption
            $table->string('mime_type', 100)->nullable();
            $table->unsignedSmallInteger('sort_order')->nullable(); // Kolom sort_order


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
