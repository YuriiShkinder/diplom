<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $category_rep;
    protected $comment_rep;
    protected $article_rep;
    protected $order_rep;
    protected $user_rep;
    protected $brand_rep;
    public $title;
    public $template;
    protected $vars=[];

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->category_rep=$categoryRepository;
    }

    public function renderOutput()
    {

        $menu=$this->getMenu();
        $header = view('header')->with('menu',$menu)->render();

        $this->vars = array_add($this->vars, 'header', $header);

        $footer=view('footer')->render();

        $this->vars=array_add($this->vars,'footer',$footer);

        $this->vars=array_add($this->vars,'title',$this->title);

        return view($this->template)->with($this->vars);

    }

    public function getMenu(){

        $menuCategory=$this->category_rep->get();
      
        if($menuCategory){
            $mBuilder=\Menu::make('MyNav',function ($m) use ($menuCategory){

                foreach ($menuCategory as $item){
                    if($item->parent_id==0){
                        $m->add($item->title,'/')->id($item->id);
                    }
                }
                foreach ($m->roots() as $item){
                    $subCategory=$menuCategory->where('parent_id',$item->id);
                    foreach ($subCategory as $sub){
                        $m->find($sub->parent_id)->add($sub->title,route('categoryArticle',['category'=>$sub->alias]))->id($sub->id);
                    }

                }

            });
            return $mBuilder;
        }
       return false;

    }
}
