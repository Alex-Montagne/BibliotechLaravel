<?php

namespace Database\Factories;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livre>
 */
class LivreFactory extends Factory
{
    protected $model = Livre::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->sentence(4),
            'auteur' => $this->faker->name(),
            'annee' => $this->faker->year(),
            'nb_pages' => $this->faker->numberBetween(100, 800),
            'isbn' => $this->faker->isbn13(),
            'resume' => $this->faker->paragraph(3),
            'couverture' => null,
            'disponible' => $this->faker->boolean(80),
            'categorie_id' => Categorie::factory(),
        ];
    }

    /**
     * Indiquer un livre non disponible
     */
    public function unavailable(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'disponible' => false,
            ];
        });
    }

    /**
     * Indiquer un livre d'une catégorie spécifique
     */
    public function forCategorie(Categorie $categorie): Factory
    {
        return $this->state(function (array $attributes) use ($categorie) {
            return [
                'categorie_id' => $categorie->id,
            ];
        });
    }
}
