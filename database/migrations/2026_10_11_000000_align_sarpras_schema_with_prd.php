<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'name') && ! Schema::hasColumn('users', 'nama')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('name', 'nama');
            });
        }

        if (! Schema::hasColumn('ruangans', 'nama_ruangan')) {
            Schema::table('ruangans', function (Blueprint $table) {
                $table->string('nama_ruangan')->default('');
            });

            DB::table('ruangans')->where('nama_ruangan', '')->update([
                'nama_ruangan' => DB::raw('kode_ruangan'),
            ]);
        }

        if (Schema::hasColumn('berita_acaras', 'tangga') && ! Schema::hasColumn('berita_acaras', 'tanggal')) {
            Schema::table('berita_acaras', function (Blueprint $table) {
                $table->renameColumn('tangga', 'tanggal');
            });
        }

        if (! Schema::hasColumn('laporan_saranas', 'jenis_kerusakan')) {
            Schema::table('laporan_saranas', function (Blueprint $table) {
                $table->string('jenis_kerusakan')->default('Lainnya');
            });
        }

        if (Schema::hasColumn('saranas', 'id_kategori_sarana') && ! Schema::hasColumn('saranas', 'id_kategori')) {
            Schema::table('saranas', function (Blueprint $table) {
                $table->dropForeign(['id_kategori_sarana']);
                $table->renameColumn('id_kategori_sarana', 'id_kategori');
            });
        }

        Schema::table('saranas', function (Blueprint $table) {
            $table->dropForeign(['id_ruangan']);
            $table->foreign('id_kategori')->references('id')->on('kategori_saranas')->restrictOnDelete();
            $table->foreign('id_ruangan')->references('id')->on('ruangans')->restrictOnDelete();
        });

        Schema::table('laporan_saranas', function (Blueprint $table) {
            $table->dropForeign(['id_sarana']);
            $table->dropForeign(['id_ruangan']);
            $table->foreign('id_sarana')->references('id')->on('saranas')->restrictOnDelete();
            $table->foreign('id_ruangan')->references('id')->on('ruangans')->restrictOnDelete();
        });

        Schema::table('berita_acaras', function (Blueprint $table) {
            $table->dropForeign(['id_sarana']);
            $table->foreign('id_sarana')->references('id')->on('saranas')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('berita_acaras', function (Blueprint $table) {
            $table->dropForeign(['id_sarana']);
            $table->foreign('id_sarana')->references('id')->on('saranas')->cascadeOnDelete();
        });

        Schema::table('laporan_saranas', function (Blueprint $table) {
            $table->dropForeign(['id_sarana']);
            $table->dropForeign(['id_ruangan']);
            $table->foreign('id_sarana')->references('id')->on('saranas')->cascadeOnDelete();
            $table->foreign('id_ruangan')->references('id')->on('ruangans')->cascadeOnDelete();
        });

        Schema::table('saranas', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropForeign(['id_ruangan']);
            $table->foreign('id_kategori')->references('id')->on('kategori_saranas')->cascadeOnDelete();
            $table->foreign('id_ruangan')->references('id')->on('ruangans')->cascadeOnDelete();
        });

        Schema::table('laporan_saranas', function (Blueprint $table) {
            $table->dropColumn('jenis_kerusakan');
        });

        Schema::table('berita_acaras', function (Blueprint $table) {
            $table->renameColumn('tanggal', 'tangga');
        });

        Schema::table('ruangans', function (Blueprint $table) {
            $table->dropColumn('nama_ruangan');
        });

        Schema::table('saranas', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->renameColumn('id_kategori', 'id_kategori_sarana');
            $table->foreign('id_kategori_sarana')->references('id')->on('kategori_saranas')->cascadeOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('nama', 'name');
        });
    }
};
