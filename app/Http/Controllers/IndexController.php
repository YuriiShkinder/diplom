<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class IndexController extends SiteController
{

    public function __construct(ArticleRepository $articleRepository,CommentRepository $commentRepository)
    {
        parent::__construct(new CategoryRepository(new Category()) );
        $this->article_rep=$articleRepository;
        $this->comment_rep=$commentRepository;
        $this->template='index';

    }
    public function index()
    {
        $this->title='Home';
        $sliderItem=$this->getSliders();
        $sliders=view('slider')->with('sliders',$sliderItem)->render();
        $this->vars=array_add($this->vars,'sliders',$sliders);

        $content=view('indexContent')->with([
            'bestSellers'=> $this->article_rep->orderBy('discount',8),
            'manyLikes'=> $this->article_rep->orderBy('like',4),
            'topComments'=>   $this->comment_rep->topComments(6)
        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function getSliders(){
            $articles=$this->article_rep->get();
            return $articles ? $articles->random(3):false;
    }


}
