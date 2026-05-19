<?php

// Password reset routes are intentionally disabled.
// This is a single-user personal portfolio — password recovery is done
// directly via `php artisan tinker` if ever needed.

test('forgot password screen is closed', function () {
    $this->get('/forgot-password')->assertStatus(404);
});

test('reset password endpoint is closed', function () {
    $this->post('/forgot-password', ['email' => 'test@example.com'])->assertStatus(404);
});
