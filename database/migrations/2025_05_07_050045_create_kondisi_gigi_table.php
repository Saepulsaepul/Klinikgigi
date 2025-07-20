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
        Schema::create('kondisi_gigi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaan_gigi')->onDelete('cascade');
            $table->string('nomor_gigi');
            $table->string('kondisi'); // contoh: berlubang, sehat, hilang
            $table->string('tindakan')->nullable(); // contoh: tambal, cabut
            $table->text('catatan')->nullable(); // catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisi_gigi');
    }
};
