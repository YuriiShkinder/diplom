<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends SiteController
{
    public function __construct(ArticleRepository $articleRepository)
    {
        parent::__construct(new CategoryRepository(new Category()) );
        $this->article_rep=$articleRepository;
        $this->template='article';

    }
    public function index()
    {
        $this->title='Корзина';
        $cartItems=Cart::instance('cart')->content();
        $content=view('cart',compact('cartItems'))->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function addProduct(Request $request,Article $article)
    {
        $article->img=json_decode($article->img);
        Cart::instance('cart')->add($article->id,$article->title,$request->get('data'),$article->price, ['img' => $article->img->colection[0]]);
        return response()->json(['success'=>true]);
    }

    public function updateProduct(Request $request,$id)
    {
        Cart::instance('cart')->update($id,['qty'=>$request->get('data')]);
        return response()->json(['success'=>true]);
    }

    public function removeProduct($id)
    {
        Cart::instance('cart')->remove($id);
        return response()->json(['success'=>true]);
    }
}
