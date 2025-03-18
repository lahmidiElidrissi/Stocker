<?php

namespace Database\Factories;
use App\Models\categorie;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\categorie>
 */
class categorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = categorie::class;
    public function definition()
    {
        return [
            'NomeCategorie' => $this->faker->company(),
        ];
    }
}
