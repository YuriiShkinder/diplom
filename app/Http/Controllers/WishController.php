<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Cart;
use Illuminate\Http\Request;

class WishController extends SiteController
{
    public function __construct(ArticleRepository $articleRepository)
    {
        parent::__construct(new CategoryRepository(new Category()) );
        $this->article_rep=$articleRepository;
        $this->template='article';
    }

    public function index()
    {
        $this->title='Wish';
        $cartItems=Cart::instance('wishlist')->content();
        $content=view('wish',compact('cartItems'))->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function addWish(Article $article){
        $article->img=json_decode($article->img);

        Cart::instance('wishlist')->add($article->id,$article->title,1,$article->price, ['img' => $article->img->colection[0]]);
        return response()->json(['success'=>true]);
    }

    public function addCart(Article $article){
        $article->img=json_decode($article->img);
        Cart::instance('cart')->add($article->id,$article->title,1,$article->price, ['img' => $article->img->colection[0]]);
        return response()->json(['success'=>true]);
    }

    public function removeWish($id){
        Cart::instance('wishlist')->remove($id);
        return response()->json(['success'=>true]);
    }
}
