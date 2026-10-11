<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sarana extends Model
{
    protected $fillable = [
        'kode_sarana',
        'nama_sarana',
        'id_kategori',
        'id_ruangan',
        'kondisi',
        'status_perbaikan',
        'jumlah',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSarana::class, 'id_kategori');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(LaporanSarana::class, 'id_sarana');
    }

    public function beritaAcara(): HasMany
    {
        return $this->hasMany(BeritaAcara::class, 'id_sarana');
    }
}
