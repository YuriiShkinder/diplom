<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
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

        for ($i = 0; $i < 50; $i++) {

            DB::table('comments')->insert([
                'text' => $faker->text(200),
                'parent_id'=>0,
                'user_id' => \App\User::all()->random()->id,
                'article_id' => \App\Article::all()->random()->id,
                'created_at' => Carbon::now(),
            ]);
        }

        for ($i = 0; $i < 80; $i++) {
            $comment=\App\Comment::all()->random();
            DB::table('comments')->insert([
                'text' => $faker->text(200),
                'parent_id'=>$comment->id,
                'user_id' => \App\User::all()->random()->id,
                'article_id' => $comment->article_id,
                'created_at' => Carbon::now(),
            ]);
        }

    }
}
