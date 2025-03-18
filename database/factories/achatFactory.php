<?php

namespace Database\Factories;
use Illuminate\Support\Facades\App;
use App\Models\achat;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\achat>
 */
class achatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = achat::class;

    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'contenir_id' => $this->faker->numberBetween(1, 10),
            'fournisseur_id' => $this->faker->numberBetween(1, 10),
            'Referance' => $this->faker->ean8(),
            'total' => $this->faker->numberBetween(0, 5000),
            'paye' => $this->faker->numberBetween(0, 5000),
            'du' => $this->faker->numberBetween(0, 5000),
        ];
    }
}
