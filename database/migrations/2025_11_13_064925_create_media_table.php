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
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');          // PK
            $table->string('ref_table', 50); // 'pengaduan' atau 'tindak_lanjut'
            $table->unsignedBigInteger('ref_id');
            $table->string('file_url');
            $table->string('caption')->nullable();
            $table->string('mime_type', 50);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['ref_table', 'ref_id']); // Indeks Polimorfik
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
