<?php

// Email verification routes are intentionally disabled.
// This is a single-user personal portfolio — email verification is unnecessary.

test('email verification screen is closed', function () {
    $this->get('/verify-email')->assertStatus(404);
});
