<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $updates = [
            'Corrugated cardboard' => 'corrugated_cardboard.jpg',
            'Kraft paper' => 'kraft_paper.jpg',
            'Paperboard cartons' => 'paperboard_cartons.jpg',
            'Newspaper wrap' => 'newspaper_wrap.jpg',
            'Molded pulp trays' => 'molded_pulp_trays.jpg',
            'PET (Polyethylene Terephthalate)' => 'pet_bottle.jpg',
            'HDPE (High-Density Polyethylene)' => 'hdpe_bottle.jpg',
            'LDPE (Low-Density Polyethylene)' => 'ldpe_bag.jpg',
            'PP (Polypropylene)' => 'pp_container.jpg',
            'Stretch film' => 'stretch_film.jpg',
            'Glass bottles' => 'glass_bottle.jpg',
            'Glass jars' => 'glass_jar.jpg',
            'Aluminum cans' => 'aluminum_can.jpg',
            'Tin cans' => 'tin_can.jpg',
            'Aluminum foil' => 'aluminum_foil.jpg',
            'Bagasse (sugarcane fiber)' => 'bagasse.jpg',
            'Cornstarch bioplastic' => 'cornstarch_bioplastic.jpg',
            'Mushroom packaging' => 'mushroom_packaging.jpg',
            'Paper-based mailers' => 'paper_mailer.jpg',
            'Bubble wrap' => 'bubble_wrap.jpg',
        ];

        foreach ($updates as $name => $image) {
            DB::table('products')->where('name', $name)->update(['image' => $image]);
        }
        echo "Product images updated!\n";
    }
}
