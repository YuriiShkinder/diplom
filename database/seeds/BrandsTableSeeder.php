<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\Brand::truncate();
        DB::statement("SET foreign_key_checks=1");

        $faker = Faker\Factory::create();
        $limit = 40;
        for ($i = 0; $i < $limit; $i++) {
            $title=$faker->unique()->company;
            DB::table('brands')->insert([
                'name' => ucfirst($title)
            ]);
        }
    }
}
