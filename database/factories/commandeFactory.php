<?php

namespace Database\Factories;
use App\Models\commande;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\commande>
 */
class commandeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = commande::class;
    public function definition()
    {
        return [
            'dateCommnde' => $this->faker->date(),
            'client_id' => $this->faker->numberBetween(1, 10),
            'article_id' => $this->faker->numberBetween(1, 10),
            'total' => $this->faker->numberBetween(1, 100),
            'paye' => $this->faker->numberBetween(1, 50),
            'du' => $this->faker->numberBetween(1, 50),
        ];
    }
}
