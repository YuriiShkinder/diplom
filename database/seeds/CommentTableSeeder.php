<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\Comment::truncate();
        DB::statement("SET foreign_key_checks=1");

        $faker = Faker\Factory::create();
        $limit = 1000;
        for ($i = 0; $i < $limit; $i++) {

            DB::table('comments')->insert([
                'text' => $faker->text(200),
                'parent_id'=>0,
                'like' => $faker->numberBetween(0,50),
                'dislike' => $faker->numberBetween(0,10),
                'user_id' => \App\User::all()->random()->id,
                'article_id' => \App\Article::all()->random()->id,
            ]);
        }
        $comments=\App\Comment::all();
        $parent=$comments->random( $comments->count()/4);
        $children=$comments->diff($parent);

        $children->map(function ($item, $key) use ($parent){
            $item->parent_id=$parent->random()->id;
            $item->update();
        });
    }
}
