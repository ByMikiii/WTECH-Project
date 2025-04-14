<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;

        $sneakers = [
            ["name" => "Nike Air Max 90 Futura", "slug" => "nike-air-max-1-97-sean-wotherspoon"],
            ["name" => "Reebok Club C 85 Vintage", "slug" => "reebok-question-mid-packer-blacktop"],
            ["name" => "Nike Free Run 5.0", "slug" => "nike-joyride-run-flyknit"],
            ["name" => "Air Jordan 6 'Carmine'", "slug" => "air-jordan-4-retro-midnight-navy"],
            ["name" => "Nike Air Max 270 React", "slug" => "air-jordan-1-retro-high-og-travis-scott"],
            ["name" => "Nike Blazer Mid '77 Vintage", "slug" => "union-la-air-jordan-4-guava-ice"],
            ["name" => "Nike SB Dunk Low 'Orange Label'", "slug" => "neckface-nike-sb-dunk-low"],
            ["name" => "Nike LeBron 20", "slug" => "nike-ja-1-hunger"],
            ["name" => "Air Jordan 3 'Cardinal Red'", "slug" => "air-jordan-4-bred-2019"],
            ["name" => "Air Jordan 1 Mid 'Barely Rose'", "slug" => "air-jordan-1-high-court-purple"],
            ["name" => "New Balance 5740 'Moonbeam'", "slug" => "new-balance-9060-ivory-cream"],
            ["name" => "Adidas Forum Low Bold", "slug" => "adidas-yeezy-boost-350-v2-zebra"],
            ["name" => "Nike Air Huarache Craft", "slug" => "nike-dunk-low-usc"],
            ["name" => "Nike Air Force 1 Shadow", "slug" => "nike-air-force-1-low-chicago"],
            ["name" => "Adidas Ozweego Celox", "slug" => "adidas-forum-low-bold-w"],
            ["name" => "Puma Cali Wedge White", "slug" => "puma-cali-wedge-white-w"],
        ];

        $sneaker = $sneakers[$index++];
        $price = $this->faker->randomFloat(2, 90, 250);
        $isSale = $this->faker->boolean();

        return [
            'name' => $sneaker['name'],
            'slug' => $sneaker['slug'],
            'description' => $this->faker->sentence(20),
            'manufacturer' => $this->faker->randomElement(['Nike', 'Adidas', 'New Balance', 'Reebok', 'Puma']),
            'gender' => $this->faker->randomElement(['Men', 'Women', 'Unisex']),
            'color' => $this->faker->safeColorName(),
            'type' => $this->faker->randomElement(['Sneaker', 'Running Shoe', 'Basketball Shoe']),
            'price' => $price,
            'isSale' => $isSale,
            'salePrice' => $isSale ? max(0, $price - $this->faker->randomFloat(2, 10, 80)) : 0.00,
            'release_date' => $this->faker->dateTimeBetween('2018-01-01', '2025-01-01')->format('Y-m-d'),
        ];
    }
}
