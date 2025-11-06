<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrateur',
                'email' => 'admin@pneumatique.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_active' => true,
                'last_activity' => now(),
            ],
            [
                'name' => 'Direction',
                'email' => 'direction@pneumatique.com',
                'password' => bcrypt('password'),
                'role' => 'direction',
                'is_active' => true,
                'last_activity' => now()->subMinutes(10),
            ],
            [
                'name' => 'Jean Kouassi',
                'email' => 'declarateur@pneumatique.com',
                'password' => bcrypt('password'),
                'role' => 'declarateur',
                'is_active' => true,
                'last_activity' => now()->subMinutes(30),
            ],
            [
                'name' => 'Marie Traoré',
                'email' => 'mecanicien@pneumatique.com',
                'password' => bcrypt('password'),
                'role' => 'mecanicien',
                'is_active' => true,
                'last_activity' => now()->subHours(2),
            ],
            [
                'name' => 'Pierre Koné',
                'email' => 'pierre@pneumatique.com',
                'password' => bcrypt('password'),
                'role' => 'declarateur',
                'is_active' => false,
                'last_activity' => now()->subDays(5),
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
