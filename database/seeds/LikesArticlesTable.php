<?php

use Illuminate\Database\Seeder;

class LikesArticlesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\LikeArticle::truncate();
        DB::statement("SET foreign_key_checks=1");

        $users=\App\User::all();
        $articles=\App\Article::all();

     foreach ($articles as $article){
         $arr=[];
         foreach ($users as $user){
             $arr[]=[
                 'user_id'=>$user->id,
                 'article_id'=>$article->id,
                 'count'=>mt_rand(0,5)
             ];
         }
         DB::table('likes_articles')->insert($arr);
     }


    }
}
