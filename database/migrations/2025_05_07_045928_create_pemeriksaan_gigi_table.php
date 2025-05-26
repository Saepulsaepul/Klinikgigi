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
        Schema::create('pemeriksaan_gigi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal_pemeriksaan')->onDelete('cascade');
            
            $table->date('tanggal_pemeriksaan');
            $table->text('keluhan_pasien')->nullable();         // ✅ ditambahkan
            $table->text('diagnosis')->nullable();              // ✅ ditambahkan
            $table->text('rencana_perawatan')->nullable();      // ✅ ditambahkan
            $table->text('catatan_tambahan')->nullable();       // ✅ ditambahkan
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_gigi');
    }
};
