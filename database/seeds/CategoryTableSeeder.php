<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\Category::truncate();
        DB::statement("SET foreign_key_checks=1");

        $faker = Faker\Factory::create();
        $limit = 30;
        for ($i = 0; $i < $limit; $i++) {
            $title=$faker->unique()->word;
            DB::table('categories')->insert([
                'title' => ucfirst($title),
                'parent_id' =>0 ,
                'alias' => $title,
            ]);
        }

        $category=\App\Category::all();
        $parent=$category->random(5);
        $children=$category->diff($parent);
        $children->map(function ($item, $key) use ($parent){
                    $item->parent_id=$parent->random()->id;
                    $item->update();
        });

    }
}
