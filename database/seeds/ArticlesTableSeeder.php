<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\Article::truncate();
        DB::statement("SET foreign_key_checks=1");

        $faker = Faker\Factory::create();
        $limit = 150;
        File::deleteDirectory(public_path('assets/images/products'),  true);
        File::makeDirectory(public_path('assets/images/products'), $mode = 0777, true, true);
        for ($i = 0; $i < $limit; $i++) {

            $obj = new \stdClass();

            $obj->path = $faker->image(public_path('assets/images/products'),840,680,array_random(['fashion','transport','nightlife','cats']),false);
            $obj->colection =[
               $faker->image(public_path('assets/images/products'),640,480,array_random(['fashion','transport','nightlife','cats']),false),
               $faker->image(public_path('assets/images/products'),640,480,array_random(['fashion','transport','nightlife','cats']),false),
                $faker->image(public_path('assets/images/products'),640,480,array_random(['fashion','transport','nightlife','cats']),false),
               $faker->image(public_path('assets/images/products'),640,480,array_random(['fashion','transport','nightlife','cats']),false),
            ];

            $img=json_encode($obj);

            $discount=rand(-10,20);
            $discount=$discount>=0?$discount:0;
            DB::table('articles')->insert([
                'title' => $faker->sentence(),
                'text' => $faker->text(800),
                'desc' => $faker->text(500),
                'img' => $img,
                'price' => $faker->numberBetween(50,5000) ,
                'like' => $faker->numberBetween(10,75),
                'discount' => $discount,
                'category_id' => \App\Category::where('parent_id','>',0)->get()->random()->id,
                'brand_id' => \App\Brand::all()->random()->id,
            ]);
        }
    }
}
