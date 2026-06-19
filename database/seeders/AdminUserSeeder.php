<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@teatrino.com'],
            [
                'name' => 'Teatrino Admin',
                'password' => 'password',
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
