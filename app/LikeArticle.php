<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeArticle extends Model
{
    protected $guarded=[];
    protected $table='likes_articles';
}
