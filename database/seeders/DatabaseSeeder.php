<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            User::factory()->admin()->make(),
            User::factory()->petugasSarpras()->make(),
            User::factory()->guru()->make(),
            User::factory()->murid()->make(),
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user->email],
                $user->getAttributes(),
            );
        }
    }
}
