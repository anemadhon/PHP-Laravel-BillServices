<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 'type' . Str::random(6),
                'name' => 'Pulsa',
                'slug' => 'pulsa',
                'cost' => 1500
            ],
            [
                'id' => 'type' . Str::random(6),
                'name' => 'EMoney',
                'slug' => 'emoney',
                'cost' => 2000
            ],
            [
                'id' => 'type' . Str::random(6),
                'name' => 'Tagihan',
                'slug' => 'tagihan',
                'cost' => 2500
            ],
        ];

        \App\Models\Category::insert($data);
    }
}
