<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur administrateur
        User::create([
            'name' => 'Admin BiblioTech',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Créer un bibliothécaire
        User::create([
            'name' => 'Bibliothécaire Demo',
            'email' => 'bibliothecaire@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'bibliothécaire',
        ]);

        // Créer un utilisateur ordinaire
        User::create([
            'name' => 'Utilisateur Demo',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'user',
        ]);
    }
}
