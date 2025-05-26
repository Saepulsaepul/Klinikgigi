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
        Schema::create('jadwal_pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('dokter'); // Changed from foreign key to string
            $table->date('tanggal');
            $table->time('jam'); // Changed from 'waktu' to 'jam'
            $table->enum('status', ['terjadwal', 'terkonfirmasi', 'selesai', 'batal'])->default('terjadwal');
            $table->text('keterangan')->nullable(); // Changed from 'catatan' to 'keterangan'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pemeriksaan');
    }
};