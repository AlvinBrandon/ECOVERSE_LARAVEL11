<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // Custom product list
        static $products = [
            [
                'name' => 'Corrugated cardboard',
                'description' => 'Common for boxes, recyclable',
                'type' => 'Paper-Based',
            ],
            [
                'name' => 'Kraft paper',
                'description' => 'Used for bags, eco-friendly',
                'type' => 'Paper-Based',
            ],
            [
                'name' => 'Paperboard cartons',
                'description' => 'Cereal boxes, folding boxes',
                'type' => 'Paper-Based',
            ],
            [
                'name' => 'Newspaper wrap',
                'description' => 'Old papers used for packaging',
                'type' => 'Paper-Based',
            ],
            [
                'name' => 'Molded pulp trays',
                'description' => 'Egg cartons, electronics',
                'type' => 'Paper-Based',
            ],
            [
                'name' => 'PET (Polyethylene Terephthalate)',
                'description' => 'Water bottles, recyclable',
                'type' => 'Plastic',
            ],
            [
                'name' => 'HDPE (High-Density Polyethylene)',
                'description' => 'Milk jugs, shampoo bottles',
                'type' => 'Plastic',
            ],
            [
                'name' => 'LDPE (Low-Density Polyethylene)',
                'description' => 'Shopping bags, squeeze bottles',
                'type' => 'Plastic',
            ],
            [
                'name' => 'PP (Polypropylene)',
                'description' => 'Yogurt cups, caps, food containers',
                'type' => 'Plastic',
            ],
            [
                'name' => 'Stretch film',
                'description' => 'Pallet wrapping, thin plastic',
                'type' => 'Plastic',
            ],
            [
                'name' => 'Glass bottles',
                'description' => 'Beverages, sauces',
                'type' => 'Glass',
            ],
            [
                'name' => 'Glass jars',
                'description' => 'Jams, baby food',
                'type' => 'Glass',
            ],
            [
                'name' => 'Aluminum cans',
                'description' => 'Soft drinks, recyclable',
                'type' => 'Metal',
            ],
            [
                'name' => 'Tin cans',
                'description' => 'Canned foods',
                'type' => 'Metal',
            ],
            [
                'name' => 'Aluminum foil',
                'description' => 'Food wrap, bakery items',
                'type' => 'Metal',
            ],
            [
                'name' => 'Bagasse (sugarcane fiber)',
                'description' => 'Takeout containers, compostable',
                'type' => 'Biodegradable',
            ],
            [
                'name' => 'Cornstarch bioplastic',
                'description' => 'Eco-packaging alternative',
                'type' => 'Biodegradable',
            ],
            [
                'name' => 'Mushroom packaging',
                'description' => 'Protective and compostable',
                'type' => 'Biodegradable',
            ],
            [
                'name' => 'Paper-based mailers',
                'description' => 'Recyclable envelopes',
                'type' => 'Biodegradable',
            ],
            [
                'name' => 'Bubble wrap',
                'description' => 'Can be reused or recycled (some types)',
                'type' => 'Protective',
            ],
        ];
        static $index = 0;
        $product = $products[$index % count($products)];
        $index++;
        return [
            'name' => $product['name'],
            'description' => $product['description'],
            'type' => $product['type'],
            'price' => fake()->randomFloat(2, 1000, 10000),
        ];
    }
}
