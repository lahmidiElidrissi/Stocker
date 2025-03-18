<?php

namespace Database\Factories;
use App\Models\fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\fournisseur>
 */
class fournisseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = fournisseur::class;
    public function definition()
    {
        return [
            'Nom' => $this->faker->name(),
            'image' => $this->faker->imageUrl(640, 480, 'personne', true),
            'email' => $this->faker->email(),
            'telephone' => $this->faker->phoneNumber(),
        ];
    }
}
