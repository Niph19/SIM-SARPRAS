<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanSarana extends Model
{
    protected $fillable = [
        'id_murid',
        'id_sarana',
        'id_ruangan',
        'jenis_kerusakan',
        'deskripsi_kerusakan',
        'foto',
        'status',
        'tanggal_laporan',
    ];

    protected function casts(): array
    {
        return ['tanggal_laporan' => 'datetime'];
    }

    public function murid(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_murid');
    }

    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class, 'id_sarana');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }
}
