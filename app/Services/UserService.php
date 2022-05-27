<?php

namespace App\Services;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Arr;


class UserService
{
    public function create($attributes) 
    {
        $user = User::where('email', Arr::get($attributes, 'email'))->first();
        if(!empty($user)) {
            return 3;
        } else {
            $user = User::create([
                'email' => Arr::get($attributes, 'email'),
                'password' => bcrypt(Arr::get($attributes, 'password')),
                'name' => Arr::get($attributes, 'name'),
                'role_id' => Arr::get($attributes, 'role_id')
            ]);
            $user->profile()->create([
                'user_id' => $user->id,
                'firstname' => Arr::get($attributes, 'fist_name'),
                'lastname' => Arr::get($attributes, 'last_name'),
                'furi_firstname' => Arr::get($attributes, 'first_kana_name'),
                'furi_lastname' => Arr::get($attributes, 'last_kana_name'),
                'gender' => Arr::get($attributes, 'gender'),
                'birthday' =>  Arr::get($attributes, 'birth_year').'-'.sprintf("%02d", Arr::get($attributes, 'birth_month')).'-'.sprintf("%02d", Arr::get($attributes, 'birth_day')),
                'phone' => Arr::get($attributes, 'phone'),
                'pref' => Arr::get($attributes, 'pref'),
            ]);
            \App\Jobs\SendEmailJob::dispatch($user, new \App\Notifications\UserRegister([
                'user_name' => Arr::get($attributes, 'first_name') . Arr::get($attributes, 'last_name')
            ]));
        }
    }
}