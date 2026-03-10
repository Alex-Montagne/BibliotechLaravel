<?php

namespace Database\Factories;

use App\Models\Vinyle;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vinyle>
 */
class VinyleFactory extends Factory
{
    protected $model = Vinyle::class;

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
            'nb_tours' => $this->faker->numberBetween(33, 45, 78),
            'num_serie' => $this->faker->unique()->word(),
            'disponible' => $this->faker->boolean(80),
            'categorie_id' => Categorie::factory(),
        ];
    }

    /**
     * Indiquer un vinyle non disponible
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
     * Indiquer un vinyle d'une catégorie spécifique
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
