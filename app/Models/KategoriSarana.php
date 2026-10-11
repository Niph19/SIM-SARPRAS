<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSarana extends Model
{
    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function saranas(): HasMany
    {
        return $this->hasMany(Sarana::class, 'id_kategori');
    }
}
