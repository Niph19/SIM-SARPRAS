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
        Schema::create('berita_acaras', function (Blueprint $table) {
            $table->id();
            $table->string('no_berita_acara')->unique();
            $table->foreignId('id_user_pembuat')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_sarana')->constrained('saranas')->onDelete('cascade');
            $table->enum('jenis_tindakan', ['perbaikan', 'pemeliharaan', 'penghapusan']);
            $table->text('keterangan');
            $table->date('tangga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acaras');
    }
};
