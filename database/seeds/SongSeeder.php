<?php

use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['song_name' => 'Fidale','artist' => 'Zigan Aldi', 'cat_id' => 1],
            ['song_name' => 'Benibeni','artist' => 'Zigan Aldi', 'cat_id' => 1],
            ['song_name' => 'No 49','artist' => 'Beethoven', 'cat_id' => 2],
            ['song_name' => 'No 68','artist' => 'Beethoven', 'cat_id' => 2],

        ];

        foreach ($items as $item) {
            \App\Model\Song::create($item);
        }
    }
}


