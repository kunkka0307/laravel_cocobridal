<?php

namespace App\Services;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Arr;

class ProfileService
{
    public function updateMain($attributes) 
    {
        $profile = Profile::where('user_id', Arr::get($attributes, 'user_id'))->first();
        $profile->update([
            'firstname' => Arr::get($attributes, 'firstname'),
            'lastname' =>  Arr::get($attributes, 'lastname'),
            'furi_firstname' =>  Arr::get($attributes, 'hira_firstname'),
            'furi_lastname' =>  Arr::get($attributes, 'hira_lastname'),
            'gender' =>  Arr::get($attributes, 'gender'),
            'birthday' =>   Arr::get($attributes, 'birth_year').'-'.sprintf("%02d", Arr::get($attributes, 'birth_month')).'-'.sprintf("%02d", Arr::get($attributes, 'birth_day')),
            'phone' =>  Arr::get($attributes, 'phone')
        ]);
        return $profile;
    }

    public function update($attributes)
    {
        $profile = Profile::where('user_id', Arr::get($attributes, 'user_id'))->first();
        $profile->update([
            'pref' =>  Arr::get($attributes, 'password'),
            'comment' =>  Arr::get($attributes, 'password'),
            'job' =>  Arr::get($attributes, 'password'),
            'height' =>  Arr::get($attributes, 'password'),
            'income' =>  Arr::get($attributes, 'password'),
            'holiday' =>  Arr::get($attributes, 'password'),
            'hobby' =>  Arr::get($attributes, 'password'),
            'dwelling' =>  Arr::get($attributes, 'password'),
            'drink' =>  Arr::get($attributes, 'password'),
            'smoking' =>  Arr::get($attributes, 'password'),
            'cooking' =>  Arr::get($attributes, 'password'),
            'best_cooking' =>  Arr::get($attributes, 'password'),
            'birthplace' =>  Arr::get($attributes, 'password'),
            'family' =>  Arr::get($attributes, 'password'),
            'marriage_history' =>  Arr::get($attributes, 'password')
        ]);
        return $profile;
    }
}