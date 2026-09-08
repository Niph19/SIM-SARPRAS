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
        Schema::create('laporan_saranas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_murid')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_sarana')->constrained('saranas')->onDelete('cascade');
            $table->foreignId('id_ruangan')->constrained('ruangans')->onDelete('cascade'); //Lokasi Ruangan
            $table->text('deskripsi_kerusakan');
            $table->string('foto')->nullable();
            $table->enum('status', ['pending', 'dalam_perbaikan', 'selesai', 'ditolak'])->default('pending');
            $table->timestamp('tanggal_laporan')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_saranas');
    }
};
