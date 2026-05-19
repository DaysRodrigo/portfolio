<?php

// Registration is intentionally closed — only the admin account exists.
// These tests verify that the routes return 404.

test('registration screen is closed', function () {
    $this->get('/register')->assertStatus(404);
});

test('registration endpoint is closed', function () {
    $this->post('/register', [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'password'              => 'Str0ng!P@ssword1',
        'password_confirmation' => 'Str0ng!P@ssword1',
    ])->assertStatus(404);

    $this->assertGuest();
});
