<?php

namespace Database\Factories;
use App\Models\contenir;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\contenir>
 */
class contenirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = contenir::class;
    public function definition()
    {
        return [
            'Referance' => $this->faker->ean8(),
            'PayeOrigine' => $this->faker->country(),
            'DateEntree' => $this->faker->dateTimeThisYear(),
            'fournisseur_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
