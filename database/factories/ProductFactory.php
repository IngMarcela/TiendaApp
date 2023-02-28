<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'size' => 'M',
            'observation' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'reference' => function () {
                return BrandFactory::new()->create()->reference;
            },
            'shipping' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
