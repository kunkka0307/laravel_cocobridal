<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PartyFactory extends Factory
{
    protected $model = \App\Models\Party::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $open_time = Carbon::parse("2022-01-08 10:00:00")->addHour(rand(1, 10));
        $close_time = $open_time->addHour(1);

        return [
            'title' =>  $this->faker->title,
            'eyecatch' => str_replace("lorempixel.com", "picsum.photos", $this->faker->imageUrl(600, 400)),
            'male_limit' => rand(2, 20),
            'female_limit' => rand(2, 20),
            'male_price' => rand(3, 10) * 1000,
            'female_price' => rand(3, 10) * 1000,
            'room_id' => rand(1, 30),
            'content' => $this->faker->text,
            'open_date' => Carbon::parse(now()->addDay(rand(1, 20)))->format('Y-m-d'),
            'open_time' => $open_time->format('H:i:00'),
            'close_time' => $close_time->format('H:i:00'),
            'male_high_age' => rand(30, 60),
            'male_low_age' => rand(18, 30),
            'female_high_age' => rand(30, 60),
            'female_low_age' => rand(18, 30),
            'value_sense' => rand(1, 10),
            'created_at' => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ];
    }
}
