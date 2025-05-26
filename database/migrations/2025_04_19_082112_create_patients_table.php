<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_ktp')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('alamat')->nullable();

            // Perhatikan urutan: nullable() -> constrained()
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('cabang_id')->nullable()->constrained('cabangs')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
   