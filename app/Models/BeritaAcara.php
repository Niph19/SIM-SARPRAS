<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaAcara extends Model
{
    protected $fillable = [
        'no_berita_acara',
        'id_user_pembuat',
        'id_sarana',
        'jenis_tindakan',
        'keterangan',
        'tanggal',
    ];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_pembuat');
    }

    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class, 'id_sarana');
    }
}
