<?php

namespace App\Http\Controllers;


    use App\Repositories\ArticleRepository;
    use App\Repositories\BrandRepository;
    use Illuminate\Http\Request;
    use App\Repositories\CategoryRepository;
    use App\Category;
class ArticleController extends SiteController
{
    public function __construct(ArticleRepository $articleRepository,BrandRepository $brandRepository)
    {
        parent::__construct(new CategoryRepository(new Category()) );
        $this->article_rep=$articleRepository;
        $this->brand_rep=$brandRepository;
        $this->template='article';
    }

    public function index()
    {
        $this->title='Все товары';
        $content=view('allArticleContent')->with([
            'articles'=> $this->article_rep->get('*',false,false,12),
            'categoryFilter'=>$this->category_rep->get()

        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function popularProducts(){
        $this->title='Top продукты';
        $content=view('allArticleContent')->with([
            'articles'=> $this->article_rep->orderBy('like',false,12),
            'categoryFilter'=>$this->category_rep->get()

        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function bestSellers(){
        $this->title='Top скидки';

        $content=view('bestSellers')->with([
            'articles'=> $this->article_rep->orderBy('discount',false,16),
            'categoryFilter'=>$this->category_rep->get()

        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function categoryArticle($category){

       $categoryFilter= $this->category_rep->get()->filter(function ($item) use($category){
                if($item->id==$category->parent_id){

                    return $item;
                }
            if($item->parent_id==$category->parent_id){

                return $item;
            }
        });

        $this->title=$category->title;
        $content=view('bestSellers')->with([
            'articles'=> $this->article_rep->get('*',false,false,16,['category_id',$category->id]),
            'categoryFilter'=>$categoryFilter

        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function show($id)
    {

    }

}

