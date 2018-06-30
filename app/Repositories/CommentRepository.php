<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 17.06.18
 * Time: 13:07
 */

namespace App\Repositories;


use App\Comment;
use DB;

class CommentRepository extends Repository
{
  public function __construct(Comment $comment)
  {
      $this->model=$comment;
  }
    public function getComments($article){
        $comments = $article->comments()
            ->leftJoin('likes_comments', 'likes_comments.comment_id', '=', 'comments.id')
            ->select(array('comments.*',
                DB::raw('SUM(likes_comments.like) as count')
            ))
            ->groupBy('id')
            ->orderBy('count', 'DESC')
            ->get()->load('article.category');

        $comments->each(function ($item,$key){
            if (is_string($item->article->img) && is_object(json_decode($item->article->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->article->img = json_decode($item->article->img);
            }
            return $item;

        });

        return $comments;
    }
    public function topComments($take=6){

        $comments = $this->model
            ->leftJoin('likes_comments', 'likes_comments.comment_id', '=', 'comments.id')
            ->where('likes_comments.like',1)
            ->select(array('comments.*',
                DB::raw('SUM(likes_comments.like) as count')
            ))
            ->groupBy('id')
            ->orderBy('count', 'DESC')
            ->limit($take)
            ->get()->load('article.category');

        $comments->each(function ($item,$key){
            if (is_string($item->article->img) && is_object(json_decode($item->article->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->article->img = json_decode($item->article->img);
            }
            return $item;

        });

        return $comments;
    }
}