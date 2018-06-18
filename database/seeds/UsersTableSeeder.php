<?php

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
        DB::statement("SET foreign_key_checks=0");
        \App\User::truncate();
        DB::statement("SET foreign_key_checks=1");

        $faker = Faker\Factory::create();
        $limit = 10;

        File::deleteDirectory(public_path('assets/images/users'),  true);
        File::makeDirectory(public_path('assets/images/users'), $mode = 0777, true, true);
        for ($i = 0; $i < $limit; $i++) {

            DB::table('users')->insert([
                'name' => $faker->firstName,
                'last' => $faker->lastName,
                'login' => $faker->unique()->word,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address ,
                'img' => $faker->image(public_path('assets/images/users'),340,280,'people',false),

                'email' => $faker->email,
                'password' => md5('111'),

            ]);
        }
    }
}
