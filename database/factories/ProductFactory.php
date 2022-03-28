<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{


    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name() ,
            "sku" => $this->faker->unique()->sentence(4),
            "slug" => $this->faker->unique()->slug,
            "quantity" => $this->faker->randomDigit,
            "price" => $this->faker->biasedNumberBetween(1,300),
            "vendor_id" => Admin::all()->random()->id
        ];
    }
}
