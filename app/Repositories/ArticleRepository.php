<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 17.06.18
 * Time: 13:06
 */

namespace App\Repositories;


use App\Article;
use Illuminate\Support\Facades\DB;

class ArticleRepository extends Repository
{
  public function __construct(Article $article)
  {
      $this->model=$article;
  }

  public function getArticles($pagination,$orderBy=false,$where=false){

      if($where){
          $articles=$this->model->where('articles.'.$where[0],$where[1])
              ->leftJoin('likes_articles', 'likes_articles.article_id', '=', 'articles.id')
              ->select(array('articles.*',
                  DB::raw('AVG(likes_articles.count) as count')
              ))
              ->groupBy('articles.id');
      }else{
          $articles = $this->model->leftJoin('likes_articles', 'likes_articles.article_id', '=', 'articles.id')
              ->select(array('articles.*',
                  DB::raw('AVG(count) as count')
              ))
              ->groupBy('articles.id');
      }
      if($orderBy){
          $articles->orderBy($orderBy, 'DESC');
      }
      if($pagination){
          return $this->check($articles->paginate($pagination));
      }

      return $this->check($articles->get());
  }

  public function manyLikes($take=false,$pagination=false){
      $articles = $this->model
          ->leftJoin('likes_articles', 'likes_articles.article_id', '=', 'articles.id')
          ->select(array('articles.*',
              DB::raw('AVG(count) as count')
          ))
          ->groupBy('articles.id')
          ->orderBy('count', 'DESC');
      if($pagination){
          return $this->check($articles->paginate($pagination));
      }

      if($take){
          $articles=$articles->limit($take);
      }
      return $this->check($articles->get());
  }
  public function orderBy($column,$take=false,$pagination=false){


      $articles=$this->model->orderBy($column,'DESC')->with('category');
      if($take){
          $articles=$articles->take($take);
      }
      if ($pagination) {
          return $this->check($articles->paginate($pagination));
      }

      return $this->check($articles->get());
  }

}