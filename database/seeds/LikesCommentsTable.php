<?php

use Illuminate\Database\Seeder;

class LikesCommentsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement("SET foreign_key_checks=0");
        \App\LikeComment::truncate();
        DB::statement("SET foreign_key_checks=1");

        $users=\App\User::all();
        $articles=\App\Comment::all();

        foreach ($articles as $article){
            $arr=[];
            foreach ($users as $user){
                $arr[]=[
                    'user_id'=>$user->id,
                    'comment_id'=>$article->id,
                    'like'=>mt_rand(-1,1)
                ];
            }
            DB::table('likes_comments')->insert($arr);
        }

    }
}
