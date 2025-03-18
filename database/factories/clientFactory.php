<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\client;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\client>
 */
class clientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = client::class;
    public function definition()
    {
        return [
            'Nom' => $this->faker->company(),
            'Telephone' => $this->faker->phoneNumber() ,
            'Email' => $this->faker->email(),
            'Societe' => $this->faker->company(),
            'image' => $this->faker->imageUrl(640, 480, 'personne', true),
        ];
    }
}
