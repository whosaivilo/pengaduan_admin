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
        Schema::create('penilai_layanan', function (Blueprint $table) {
            $table->id('penilaian_id'); // PK
                                        // FK ke pengaduan
            $table->foreignId('pengaduan_id')->constrained('pengaduan', 'pengaduan_id')->onDelete('cascade');

            $table->unsignedTinyInteger('rating'); // 1 sampai 5
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilai_layanan');
    }
};
