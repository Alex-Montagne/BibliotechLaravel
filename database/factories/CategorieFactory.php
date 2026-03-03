<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nom = $this->faker->word();

        return [
            'nom' => $nom,
            'slug' => \Str::slug($nom),
            'description' => $this->faker->sentence(),
            'icone' => 'fas fa-book',
            'couleur' => $this->faker->hexColor(),
            'active' => true,
        ];
    }
}
