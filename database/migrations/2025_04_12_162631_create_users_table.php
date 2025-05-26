<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // Tambahkan cabang_id tanpa relasi terlebih dahulu
            $table->unsignedBigInteger('cabang_id')->nullable();

            $table->enum('role', ['admin', 'resepsionis', 'dokter', 'pasien'])->default('pasien');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
