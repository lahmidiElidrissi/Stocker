<?php

namespace Database\Factories;
use App\Models\article;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\article>
 */
class articleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = article::class;
    public function definition()
    {
        return [
            'Nome' => $this->faker->company(),
            'Prix' => $this->faker->numberBetween(200, 1000),
            'Referance' => $this->faker->ean8(),
            'categorie_id' => $this->faker->numberBetween(1, 10),
            'image' => $this->faker->imageUrl(640, 480, 'articles', true),
        ];
    }
}
