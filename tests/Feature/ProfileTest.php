<?php

use App\Models\User;

test('profile page is displayed for every role', function (string $role) {
    $user = User::factory()->create(['role' => $role]);

    $this->actingAs($user)->get('/profil')->assertOk();
})->with(['admin', 'petugas_sarpras', 'guru', 'murid']);

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put('/profil', [
            'nama' => 'Nama Baru',
            'email' => 'new@example.com',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profil');

    expect($user->fresh()->nama)->toBe('Nama Baru')
        ->and($user->fresh()->email)->toBe('new@example.com')
        ->and($user->fresh()->email_verified_at)->toBeNull();
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put('/profil', [
            'nama' => 'Nama Baru',
            'email' => $user->email,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profil');

    expect($user->fresh()->email_verified_at)->not->toBeNull();
});
