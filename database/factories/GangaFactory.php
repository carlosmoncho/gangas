<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class gangaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $precio = $this->faker->randomFloat(2, 1, 100 );
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->text(),
            'URL' => $this->faker->text(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'points' => $this->faker->randomFloat(0,1, 200 ),
            'img' => "/storage/img/1-ganga-severa.png",
            'price' => $precio,
            'discount_price' => $precio - $precio * 0.10,
            'available' => $this->faker->boolean()
        ];
    }
}
