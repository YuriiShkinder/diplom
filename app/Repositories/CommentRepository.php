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

    public function topComments($take=6){

        $comments=$this->model->orderByDesc('like')->limit($take)->get()->load('article');

        $comments->each(function ($item,$key){
            if (is_string($item->article->img) && is_object(json_decode($item->article->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->article->img = json_decode($item->article->img);
            }
            return $item;

        });

        return $comments;
    }
}