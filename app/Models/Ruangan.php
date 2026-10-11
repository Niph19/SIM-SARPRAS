<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    protected $fillable = ['kode_ruangan', 'nama_ruangan', 'lokasi'];

    public function saranas(): HasMany
    {
        return $this->hasMany(Sarana::class, 'id_ruangan');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(LaporanSarana::class, 'id_ruangan');
    }
}
