<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Brand;
use App\Category;
use App\Comment;
use App\Http\Controllers\SiteController;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\User;
use Image;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class IndexController extends SiteController
{
    public function __construct(UserRepository $userRepository,CategoryRepository $categoryRepository,ArticleRepository $articleRepository)
    {
        parent::__construct(new CategoryRepository(new Category()));
        $this->category_rep=$categoryRepository;
        $this->article_rep=$articleRepository;
        $this->user_rep=$userRepository;
        $this->template="article";
        if(Gate::denies('VIEW_ADMIN')){
            abort(403);
        }
    }

    public function index(){
        $this->title='Админ панель';
        $categories=$this->category_rep->get();
        $articles=$this->article_rep->model->with(['category','comments'])->paginate(5, ['*'], 'article');
        $articles->setPath('admin/pagination');
        $articles=$this->article_rep->check($articles);
//        $comments=$this->article_rep->model->with(['comments'])->paginate(10, ['*'], 'comments');
//        $comments->setPath('admin/comments');
        $users=$this->user_rep->get('*',false,'roles');
    $com=$this->article_rep->model::join('comments','comments.article_id','=','articles.id')->groupBy('comments.article_id')->with(['comments'])->paginate(7, ['articles.*'], 'article');
        $com->setPath('admin/comments');

        $content=view('admin')->with([
            'categories'=>$categories,
            'articles'=>$articles,
            'comments'=> $com,
            'users'=> $users
        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function pagination(){
        $articles=$this->article_rep->model->paginate(5, ['*'], 'article');
        $articles->setPath('pagination');
        $articles=$this->article_rep->check($articles);
        $content=view('adminArticle')->with([
            'articles'=>$articles
        ])->render();
        return response()->json(['content'=>$content]);
    }

    public function paginationComments(){
        $comments=$this->article_rep->model->with(['comments'])->paginate(10, ['*'], 'comments');
        $comments->setPath('admin/comments');

        $content=view('adminArticle')->with([
            'comments'=>$comments
        ])->render();
        return response()->json(['content'=>$content]);

    }

    public function addCategory(Request $request){
        $parent=$this->category_rep->model->where('parent_id',0)->get();
        if($request->isMethod('get')){
            $content=view('addCategory')->with(['parentCategory'=>$parent])->render();
            return response($content);
        }
        if($request->isMethod('post')) {

            $data=$request->except('_token');
            $rules=[
                'title'=>'required|max:255',
                'alias'=>'required|unique:categories',
                'parent_id'=>'required|integer',
            ];
            $validator=Validator::make($data,$rules);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()]);
            }
            $category= new Category();
            $category->fill($data);
            if($category->save()){
                $content=view('editCategory')->with(
                    [
                        'categories'=>$this->category_rep->model->get()
                    ]
                )->render();
                return response()->json([
                    'success'=>'ok',
                    'html'=>$content
                ]);
            }

        }

    }

    public function editCategory(Request $request,Category $category){
        $parent=$this->category_rep->model->where('parent_id',0)->get();
        if($request->isMethod('get')){
            $content=view('addCategory')->with([
                'parentCategory'=>$parent,
                'category'=>$category
            ])->render();
            return response($content);
        }
        if($request->isMethod('post')) {
            $data=$request->except('_token');
            $rules=[
                'title'=>'required|max:255',
                'alias'=>'required|unique:categories,alias,'.$category->id,
                'parent_id'=>'required|integer',
            ];
            $validator=Validator::make($data,$rules);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()]);
            }
            $category->fill($data);
            if($category->update()){
                $content=view('editCategory')->with(
                    [
                        'categories'=>$this->category_rep->model->get()
                    ]
                )->render();
                return response()->json([
                    'success'=>'ok',
                    'html'=>$content
                ]);
            }

        }
    }

    public function deleteCategory(Category $category){
        if($category->delete()){
            $content=view('editCategory')->with(
                [
                    'categories'=>$this->category_rep->model->get()
                ]
            )->render();
            return response()->json([
                'success'=>'Категория - '.$category->title.' удалена',
                'html'=>$content
            ]);
        }else{
            return response()->json([
                'error'=>'error',

            ]);
        }
    }

    public function deleteUser(User $user){
        if($user->delete()){
            return response()->json([
                'success'=>'Пользователь - '.$user->name.' '.$user->last.' удален',
            ]);
        }else{
            return response()->json([
                'error'=>'error',

            ]);
        }
    }

    public function addArticle(Request $request){

        if($request->isMethod('get')){
            $parentCategory=$this->category_rep->model->where('parent_id','>',0)->get();
            $brends=Brand::all();
                $content=view('addArticle')->with([
                'parentCategory'=>$parentCategory,
                    'brends'=>$brends
            ])->render();
            return response($content);
        }
        if($request->isMethod('post')) {

            $data=$request->except(['_token','img','slider']);

            $rules=[
                'title'=>'required|max:255',
                'text'=>'required',
                'price'=>'required|integer',
                'desc'=>'required'
            ];
            $validator=Validator::make($data,$rules);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()]);
            }

            if ($request->hasFile('img') && $request->hasFile('slider')) {
                dd(1212);
                $colection = $request->file('img');
                $slider = $request->file('slider');
                $s3 = \Storage::disk('s3');
                if ($colection && $slider) {
                    $filePathColection =[];
                    for($i=0;$i< count($colection);$i++){
                        $filePathColection[$i]="products/".str_random(4).'.jpg';
                        $image= Image::make($colection[$i])->resize(680,440)->encode('jpg');
                         \Storage::disk('s3')->put($filePathColection[$i], (string)$image, 'public');
                    }
                    $filePathSlider = "slider/".str_random(6).'.jpg';
                    $image= Image::make($slider)->resize(1200,400)->encode('jpg');
                    \Storage::disk('s3')->put($filePathSlider, (string)$image, 'public');
                    $obj = new \stdClass();
                    $obj->colection=$filePathColection;
                    $obj->slider = $filePathSlider;
                    $img=json_encode($obj);
                    $data['img']=$img;
                    $article= new Article();
                    $article->fill($data);

                    if($article->save()){

                        $articles=$this->article_rep->model->paginate(5, ['*'], 'article');
                        $articles->setPath('pagination');
                        $articles=$this->article_rep->check($articles);
                        $content=view('adminArticle')->with([
                            'articles'=>$articles
                        ])->render();
                        return response()->json([
                            'success'=>'Ноый товар добавлен',
                            'html'=>$content,
                            'type'=>1
                        ]);

                    }else{
                        return response()->json([
                            'error'=>'error save',

                        ]);
                    }
                }else{
                    return response()->json([
                        'error'=>'error foto',

                    ]);
                }
            }else{
                return response()->json([
                    'error'=>'error',

                ]);
            }
        }
    }

    public function editArticle(Request $request,Article $article){
        if($request->isMethod('get')){
            $parentCategory=$this->category_rep->model->where('parent_id','>',0)->get();
            $brends=Brand::all();
            $article->img=json_decode($article->img);
            $content=view('addArticle')->with([
                'parentCategory'=>$parentCategory,
                'brends'=>$brends,
                'article'=>$article
            ])->render();
            return response($content);
        }
        if($request->isMethod('post')){
            $s3 = \Storage::disk('s3');
            $data=$request->except(['_token','img','slider','old_slider','old_img']);

            $rules=[
                'title'=>'required|max:255',
                'text'=>'required',
                'price'=>'required|integer',
                'desc'=>'required'
            ];
            $validator=Validator::make($data,$rules);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()]);
            }
            $article->img=json_decode($article->img);
            $obj=new \stdClass();

            if ($request->hasFile('img') ){

                if($request->has('old_img')){
                    $old_img=explode(',',$request->get('old_img'));
                    foreach ($old_img as $i=>$img){
                        $old_img[$i]=substr($img,strripos($img,'products'));
                       $s3->delete(substr($img,strripos($img,'products')));
                    }
                    $newPath=array_values(array_diff($article->img->colection,$old_img));

                    $colection = $request->file('img');
                    for($i=0;$i< count($colection);$i++){
                        $name="products/".str_random(6).'.jpg';
                        $newPath[]=$name;
                        $image= Image::make($colection[$i])->resize(680,440)->encode('jpg');

                        \Storage::disk('s3')->put($name, (string)$image, 'public');
                    }
                   $obj->colection=$newPath;

                }else{
                    return response()->json([
                        'error'=>'error request old_img',

                    ]);
                }

            }else{
                $obj->colection=$article->img->colection;
            }

            if($request->hasFile('slider')){
                if($request->has('old_slider')){
                    $old_slider=$request->get('old_slider');
                    $old_slider=substr($old_slider,strripos($old_slider,'slider'));
                    $s3->delete($old_slider);

                    $obj->slider="slider/".str_random(6).'.jpg';
                        $image= Image::make($request->file('slider'))->resize(1240,400)->encode('jpg');
                        \Storage::disk('s3')->put(  $obj->slider, (string)$image, 'public');
                }else{
                    return response()->json([
                        'error'=>'error old_slider',

                    ]);
                }

            }else{
                $obj->slider=$article->img->slider;
            }
           $data['img']= json_encode($obj);

            if ($article->update($data)){

                $articles=$this->article_rep->model->paginate(5, ['*'], 'article');
                $articles->setPath('pagination');
                $articles=$this->article_rep->check($articles);
                $content=view('adminArticle')->with([
                    'articles'=>$articles
                ])->render();
                return response()->json([
                    'success'=>'Tовар обновлен',
                    'html'=>$content,
                    'type'=>1
                ]);
            }
        }
    }

    public function deleteArticle(Article $article){

        if($article->delete()){
            $articles=$this->article_rep->model->paginate(5, ['*'], 'article');
            $articles->setPath('pagination');
            $articles=$this->article_rep->check($articles);
            $content=view('adminArticle')->with([
                'articles'=>$articles
            ])->render();
            return response()->json([
                'success'=>'Tовар deleted',
                'html'=>$content,
                'type'=>1
            ]);
        }else{
            return response()->json([
                'error'=>'error',

            ]);
        }
    }

    public function viewComments(Article $article){
        $article->with(['comments.user']);
        $content=view('viewComments')->with([
            'article'=>$article
        ])->render();
        return response($content);
    }

    public function editComment(Request $request,Comment $comment){
        if ($comment->update($request->only('text'))){
            return response()->json([
                'success'=>'Comment update'
            ]);
        }

    }
}
