<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('users')->truncate();
        \DB::table('profiles')->truncate();

        \DB::table('users')->insert([
            [
                'id'   => 1,
                'role_id' => 1,
                'name' => "管理者",
                'email'=> "admin@admin.com",
                'password'=>\Hash::make('password'),
                'created_at'     => Carbon::now()->subWeek(1),
                'updated_at'     => Carbon::now()->subWeek(1),
            ],
            
        ]);

        for ($i = 2; $i < 20; $i ++) {
            \DB::table('users')->insert([
                [
                    'id'   => $i,
                    'role_id' => 2,
                    'name' => null,
                    'email'=> "test".$i."@test.com",
                    'password'=>\Hash::make('password'),
                    'created_at'     => Carbon::now()->subWeek(1),
                    'updated_at'     => Carbon::now()->subWeek(1),
                ]
            ]);

            \DB::table('profiles')->insert([
                [
                    'user_id'   => $i,
                    'gender' => ['male', 'female'][rand(0, 1)],
                    'firstname' => '姓',
                    'lastname' => '名' . $i,
                    'furi_firstname' => 'せい',
                    'furi_lastname' => 'めい' . $i,
                    'email' => "test".$i."@test.com",
                    'created_at'     => Carbon::now()->subWeek(1),
                    'updated_at'     => Carbon::now()->subWeek(1),
                ]
            ]);
        }
        
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
