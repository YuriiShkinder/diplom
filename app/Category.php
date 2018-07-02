<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $guarded=[];

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function delete(){
        $articles=$this->articles()->get()->load(['comments','likes']);
        $articles->each(function ($article){
            $article->img=json_decode($article->img);
            $article->img->colection[]=$article->img->slider;
            Storage::disk('s3')->delete($article->img->colection);
        });
       return  parent::delete();
    }

}
