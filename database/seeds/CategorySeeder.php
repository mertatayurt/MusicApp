<?php

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
        $items = [

            ['cat_name' => 'Electronic','cat_image' => 'https://via.placeholder.com/350x150', 'cat_description' => 'Electronic Music'],
            ['cat_name' => 'Classic Music','cat_image' => 'https://via.placeholder.com/350x150', 'cat_description' => 'Classic Music']

        ];

        foreach ($items as $item) {
            \App\Model\Category::create($item);
        }
    }
}
