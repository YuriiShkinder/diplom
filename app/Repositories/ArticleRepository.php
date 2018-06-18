<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 17.06.18
 * Time: 13:06
 */

namespace App\Repositories;


use App\Article;

class ArticleRepository extends Repository
{
  public function __construct(Article $article)
  {
      $this->model=$article;
  }
  public function orderBy($column,$take=false,$pagination=false){
      $articles=$this->model->orderBy($column,'DESC');
      if($take){
          $articles=$articles->take($take);
      }
      if ($pagination) {
          return $this->check($articles->paginate($pagination));
      }

      return $this->check($articles->get());
  }

}