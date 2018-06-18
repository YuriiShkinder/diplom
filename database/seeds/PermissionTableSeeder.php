<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\Permission::truncate();
        DB::table('permission_roles')->truncate();
        DB::statement("SET foreign_key_checks=1");

        DB::table('permissions')->insert([[
            'name' => 'VIEW_ADMIN'

        ],[
            'name' => 'ADD_ARTICLES'
        ],[
            'name' => 'UPDATE_ARTICLES'
        ],[
            'name' => 'DELETE_ARTICLES'
        ],[
            'name' => 'EDIT_USERS'
        ]
        ]);

        $roles=\App\Role::where('name','admin')->first()->id;
        \App\Permission::all()->each(function ($item,$key) use ($roles){
            DB::table('permission_roles')->insert([
                'role_id' => $roles,
                    'permission_id' => $item->id
            ]
            );
        });
    }
}
