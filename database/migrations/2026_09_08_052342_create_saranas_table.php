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
        Schema::create('saranas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sarana')->unique();
            $table->string('nama_sarana');
            $table->foreignId('id_kategori_sarana')->constrained('kategori_saranas')->onDelete('cascade');
            $table->foreignId('id_ruangan')->constrained('ruangans')->onDelete('cascade');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat']);
            $table->enum('status_perbaikan', ['normal', 'dalam_perbaikan']);
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saranas');
    }
};
