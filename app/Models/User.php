<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function laporanSarana(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LaporanSarana::class, 'id_murid');
    }

    public function beritaAcara(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BeritaAcara::class, 'id_user_pembuat');
    }

    public function homeRouteName(): string
    {
        return match ($this->role) {
            'admin', 'petugas_sarpras' => 'dashboard',
            'guru' => 'berita-acara.index',
            'murid' => 'laporan.index',
            default => abort(403),
        };
    }
}
