<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'nama' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('laporan.index', absolute: false));
});

test('registration always assigns the murid role', function () {
    $this->post('/register', [
        'nama' => 'Test Student',
        'email' => 'student@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'admin',
    ])->assertRedirect(route('laporan.index', absolute: false));

    expect(App\Models\User::where('email', 'student@example.com')->value('role'))->toBe('murid');
});
