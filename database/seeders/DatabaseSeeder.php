<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use InvalidArgumentException;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SARPRAS_ADMIN_EMAIL');
        $password = env('SARPRAS_ADMIN_PASSWORD');

        if (! filled($email) && ! filled($password)) {
            return;
        }

        if (! filled($email) || ! filled($password)) {
            throw new InvalidArgumentException('Set both SARPRAS_ADMIN_EMAIL and SARPRAS_ADMIN_PASSWORD to seed the administrator.');
        }

        User::firstOrCreate(
            ['email' => $email],
            ['nama' => 'Administrator', 'password' => $password, 'role' => 'admin'],
        );
    }
}
