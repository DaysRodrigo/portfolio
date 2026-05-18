<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@portfolio.local')],
            [
                'name'              => 'Rodrigo Dias Sales',
                'password'          => Hash::make(env('ADMIN_PASSWORD', 'change-me')),
                'email_verified_at' => now(),
            ]
        );
    }
}
