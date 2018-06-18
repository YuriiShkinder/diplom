<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\Role::truncate();
        DB::table('role_users')->truncate();
        DB::statement("SET foreign_key_checks=1");

        DB::table('roles')->insert([[
            'name' => 'user'

        ],[
            'name' => 'admin'
        ]]);

        $roles=\App\Role::all();
        \App\User::all()->each(function ($item,$key) use ($roles){
            DB::table('role_users')->insert([
                'role_id' => $roles->random()->id,
                'user_id' =>  $item->id

            ]);
        });
    }
}
