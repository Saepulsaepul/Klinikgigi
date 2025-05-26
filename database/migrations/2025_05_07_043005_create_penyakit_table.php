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
        Schema::create('penyakit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('patients')->onDelete('cascade');
            $table->string('nama');
            $table->date('tanggal_diagnosis');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyakit');
    }
};
