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
                'image' => 'corrugated_cardboard.jpg',
            ],
            [
                'name' => 'Kraft paper',
                'description' => 'Used for bags, eco-friendly',
                'type' => 'Paper-Based',
                'image' => 'kraft_paper.jpg',
            ],
            [
                'name' => 'Paperboard cartons',
                'description' => 'Cereal boxes, folding boxes',
                'type' => 'Paper-Based',
                'image' => 'paperboard_cartons.jpg',
            ],
            [
                'name' => 'Newspaper wrap',
                'description' => 'Old papers used for packaging',
                'type' => 'Paper-Based',
                'image' => 'newspaper_wrap.jpg',
            ],
            [
                'name' => 'Molded pulp trays',
                'description' => 'Egg cartons, electronics',
                'type' => 'Paper-Based',
                'image' => 'molded_pulp_trays.jpg',
            ],
            [
                'name' => 'PET (Polyethylene Terephthalate)',
                'description' => 'Water bottles, recyclable',
                'type' => 'Plastic',
                'image' => 'pet_bottle.jpg',
            ],
            [
                'name' => 'HDPE (High-Density Polyethylene)',
                'description' => 'Milk jugs, shampoo bottles',
                'type' => 'Plastic',
                'image' => 'hdpe_bottle.jpg',
            ],
            [
                'name' => 'LDPE (Low-Density Polyethylene)',
                'description' => 'Shopping bags, squeeze bottles',
                'type' => 'Plastic',
                'image' => 'ldpe_bag.jpg',
            ],
            [
                'name' => 'PP (Polypropylene)',
                'description' => 'Yogurt cups, caps, food containers',
                'type' => 'Plastic',
                'image' => 'pp_container.jpg',
            ],
            [
                'name' => 'Stretch film',
                'description' => 'Pallet wrapping, thin plastic',
                'type' => 'Plastic',
                'image' => 'stretch_film.jpg',
            ],
            [
                'name' => 'Glass bottles',
                'description' => 'Beverages, sauces',
                'type' => 'Glass',
                'image' => 'glass_bottle.jpg',
            ],
            [
                'name' => 'Glass jars',
                'description' => 'Jams, baby food',
                'type' => 'Glass',
                'image' => 'glass_jar.jpg',
            ],
            [
                'name' => 'Aluminum cans',
                'description' => 'Soft drinks, recyclable',
                'type' => 'Metal',
                'image' => 'aluminum_can.jpg',
            ],
            [
                'name' => 'Tin cans',
                'description' => 'Canned foods',
                'type' => 'Metal',
                'image' => 'tin_can.jpg',
            ],
            [
                'name' => 'Aluminum foil',
                'description' => 'Food wrap, bakery items',
                'type' => 'Metal',
                'image' => 'aluminum_foil.jpg',
            ],
            [
                'name' => 'Bagasse (sugarcane fiber)',
                'description' => 'Takeout containers, compostable',
                'type' => 'Biodegradable',
                'image' => 'bagasse.jpg',
            ],
            [
                'name' => 'Cornstarch bioplastic',
                'description' => 'Eco-packaging alternative',
                'type' => 'Biodegradable',
                'image' => 'cornstarch_bioplastic.jpg',
            ],
            [
                'name' => 'Mushroom packaging',
                'description' => 'Protective and compostable',
                'type' => 'Biodegradable',
                'image' => 'mushroom_packaging.jpg',
            ],
            [
                'name' => 'Paper-based mailers',
                'description' => 'Recyclable envelopes',
                'type' => 'Biodegradable',
                'image' => 'paper_mailer.jpg',
            ],
            [
                'name' => 'Bubble wrap',
                'description' => 'Can be reused or recycled (some types)',
                'type' => 'Protective',
                'image' => 'bubble_wrap.jpg',
            ],
        ];
        static $index = 0;
        $product = $products[$index % count($products)];
        $index++;
        return [
            'name' => $product['name'],
            'description' => $product['description'],
            'type' => $product['type'],
            'image' => $product['image'],
            'price' => fake()->randomFloat(2, 1000, 10000),
        ];
    }
}
