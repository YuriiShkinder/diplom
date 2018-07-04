<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\Order::truncate();
        DB::statement("SET foreign_key_checks=1");

        $faker = Faker\Factory::create();
        $limit = 50;
        for ($i = 0; $i < $limit; $i++) {
            DB::table('orders')->insert([
                'status' => rand(0,1),
                'count' => $faker->numberBetween(1,10),
                'user_id' => \App\User::all()->random()->id,
                'article_id' => \App\Article::all()->random()->id,
            ]);
        }
    }
}
