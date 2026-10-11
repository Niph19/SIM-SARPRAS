<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('asdasdasd'),
            'role' => 'murid',
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->accountForRole('admin', 'Admin', 'admin@gmail.com');
    }

    public function petugasSarpras(): static
    {
        return $this->accountForRole('petugas_sarpras', 'Petugas Sarpras', 'petugas_sarpras@gmail.com');
    }

    public function guru(): static
    {
        return $this->accountForRole('guru', 'Guru', 'guru@gmail.com');
    }

    public function murid(): static
    {
        return $this->accountForRole('murid', 'Murid', 'murid@gmail.com');
    }

    private function accountForRole(string $role, string $nama, string $email): static
    {
        return $this->state(fn (array $attributes) => [
            'nama' => $nama,
            'email' => $email,
            'password' => static::$password ??= Hash::make('asdasdasd'),
            'role' => $role,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
