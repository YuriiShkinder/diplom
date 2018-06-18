<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded=[];

    public function articles(){
        return $this->hasMany(Article::class);
    }
}
