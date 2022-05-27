<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PartysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('partys')->truncate();

        $faker = \Faker\Factory::create('ja_JP');
        for ($i = 0; $i < 100; $i++) {
            $open_time = Carbon::parse("2022-01-08 10:00:00")->addHour(rand(1, 10));
            $close_time = $open_time->addHour(1);
            \DB::table("partys")->insert([
                'title' =>  $faker->jobTitle,
                'eyecatch' => str_replace("lorempixel.com", "picsum.photos", $faker->imageUrl(600, 400)),
                'male_limit' => rand(2, 20),
                'female_limit' => rand(2, 20),
                'male_price' => rand(3, 10) * 1000,
                'female_price' => rand(3, 10) * 1000,
                'room_id' => rand(1, 29),
                'content' => $faker->text,
                'open_date' => Carbon::parse(now()->addDay(rand(-6, 10)))->format('Y-m-d'),
                'open_time' => $open_time->format('H:i:00'),
                'close_time' => $close_time->format('H:i:00'),
                'male_high_age' => rand(30, 60),
                'male_low_age' => rand(18, 30),
                'female_high_age' => rand(30, 60),
                'female_low_age' => rand(18, 30),
                'value_sense' => rand(1, 10),
                'created_at' => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ]);
        }
        
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
