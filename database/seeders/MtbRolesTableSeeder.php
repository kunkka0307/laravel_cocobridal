<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MtbRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('mtb_roles')->truncate();

        \DB::table('mtb_roles')->insert([
            [
              'id'   => 1,
              'name' => "管理者"
            ],
            [
              'id'   => 2,
              'name' => "ユーザー"
            ]
        ]);
        
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
