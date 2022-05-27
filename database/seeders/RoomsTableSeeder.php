<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('rooms')->truncate();
        \DB::table('room_images')->truncate();
        
        $faker = \Faker\Factory::create('ja_JP');

        for ($i = 1; $i < 30; $i ++) {
            \DB::table('rooms')->insert([
                [
                'id'   => $i,
                'title' => "開催場所".$i,
                'lat' => 30.12343,
                'lang' => 110.234123,
                'comment' => "コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント",
                'address' => "新宿南口ラウンジ5F".$i,
                'access' => "新宿駅／東南口から徒歩".$i."分",
                'zipcode' => "98394".$i,
                'created_at' => Carbon::now(),
                'updated_at'  => Carbon::now(),
                ]
            ]);

            for ($j = 0; $j < 5; $j++) {
                \DB::table('room_images')->insert([
                    'room_id'   => $i,
                    'image' => str_replace("lorempixel.com", "picsum.photos", $faker->imageUrl(600, 400)),
                ]);
            }
        }
        
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
