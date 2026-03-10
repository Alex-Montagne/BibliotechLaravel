<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders français pour BiblioTech
        $this->call([
            UserSeeder::class,       // Créer les utilisateurs de test
            CategorieSeeder::class,  // Créer ensuite les catégories
            LivreSeeder::class,      // Puis les livres avec relations
            VinyleSeeder::class,     // Puis les vinyles avec relations
        ]);
    }
}
