<?php

namespace App\Http\Controllers;


    use App\Article;
    use App\Comment;
    use App\Repositories\ArticleRepository;
    use App\Repositories\BrandRepository;
    use App\Repositories\CommentRepository;
    use Illuminate\Http\Request;
    use App\Repositories\CategoryRepository;
    use App\Category;
    use Illuminate\Support\Facades\DB;

    class ArticleController extends SiteController
{
    public function __construct(ArticleRepository $articleRepository,BrandRepository $brandRepository,CommentRepository$commentRepository)
    {
        parent::__construct(new CategoryRepository(new Category()) );
        $this->article_rep=$articleRepository;
        $this->brand_rep=$brandRepository;
        $this->comment_rep=$commentRepository;
        $this->template='article';
    }

    public function index()
    {
        $this->title='Все товары';
        $content=view('allArticleContent')->with([
            'articles'=> $this->article_rep->getArticles(12),
            'categoryFilter'=>$this->category_rep->get()

        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function popularProducts(){

        $this->title='Top продукты';
        $content=view('allArticleContent')->with([
            'articles'=> $this->article_rep->manyLikes(false,16),
            'categoryFilter'=>$this->category_rep->get()

        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function bestSellers(){
        $this->title='Top скидки';

        $content=view('allArticleContent')->with([
            'articles'=> $this->article_rep->getArticles(12,'discount'),
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
        $content=view('allArticleContent')->with([
            'articles'=> $this->article_rep->getArticles(16,false,['category_id',$category->id]),
            'categoryFilter'=>$categoryFilter

        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function show(Category $category,Article $article)
    {

        $article->load(['comments.user','likes']);

        $this->title=$article->title;
        $article->img=json_decode($article->img);
        $content=view('singleArticle')->with([
            'article'=> $article,
            'comments'=> $article->comments->load('likes')->groupBy('parent_id'),
            'articles'=>$this->article_rep->get('*',4)
        ])->render();
        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function articleFilter(Request $request){
        $id=json_decode($request->get('id'));

        $max=$request->get('max');
        $min=$request->get('min');

        if(!empty($id)){
            $articles = $this->article_rep->model::whereIn('articles.category_id', $id)
                ->whereBetween('articles.price', [$min, $max])
                ->leftJoin('likes_articles', 'likes_articles.article_id', '=', 'articles.id')
                ->select(array('articles.*',
                    DB::raw('AVG(likes_articles.count) as count')
                ))
                ->groupBy('articles.id')
                ->get();
        }else{
            $articles = $this->article_rep->model::whereBetween('articles.price', [$min, $max])
                ->leftJoin('likes_articles', 'likes_articles.article_id', '=', 'articles.id')
                ->select(array('articles.*',
                    DB::raw('AVG(likes_articles.count) as count')
                ))
                ->groupBy('articles.id')
                ->get();
        }

        if($request->get('type')==1){
                $articles=$this->article_rep->check($articles);
                $content=view('filterArticle')->with(['articles'=> $articles])->render();
                return response($content);
        }

        return response($articles->count()) ;

    }

    public function searchArticle(Request $request){
        $str=$request->get('data');
        $articles = $this->article_rep->model->where('title','like',"%".$str."%")->get()->load('category');
        $categories= $this->category_rep->model->where('title','like',"%".$str."%")->where('parent_id','>',0)->get()->load('articles');

        $content=view('search')->with([
            'articles'=> $articles,
            'categories'=>$categories
        ])->render();
        return response()->json(['success'=>$content]);
    }

    public function addComment(Request $request){
        $data=json_decode($request->get('data'));
        $arr=[];
        foreach ($data as $item){
            if($item->value==''){
                return response()->json(['success'=>false]);
            }
            $arr[$item->name]=$item->value;
        }
        $article=$this->comment_rep->model->fill($arr);

        if($article->save()){
            $content=view('addComment')->with([
                'item'=> $article->load('user'),
            ])->render();
        }

        return response()->json(['success'=>$content,'id'=>$article->id,'parent_id'=>$article->parent_id]);
    }

    public function likeArticle(Request $request,Article $article){
        $user=\Auth::user();
        if($user){
            $article->likes()->updateOrCreate([
                'user_id'=>$user->id
            ],[
                'count'=>$request->get('data')+1,
                'user_id'=>$user->id,
                'article_id'=>$article->id
            ]);
        }
        $width=$this->article_rep->getArticles(false,false,['id',$article->id])->first();

        return response()->json(['success'=>['width'=>$width->count]]);
    }


        public function likeComment(Request $request,Comment $comment){
            $user=\Auth::user();
            if($user){
                $comment->likes()->updateOrCreate([
                    'user_id'=>$user->id
                ],[
                    'like'=>$request->get('data') == 1 ? 1 : -1,
                    'user_id'=>$user->id,
                    'comment_id'=>$comment->id
                ]);
            }

            $sql="SELECT (SELECT COUNT(`like`) FROM likes_comments WHERE `like`=-1 and `comment_id`=$comment->id) as dislike, (SELECT COUNT(`like`) FROM likes_comments WHERE `like`=1 and `comment_id`=$comment->id) as `like` FROM likes_comments WHERE `comment_id`=$comment->id GROUP BY `comment_id`";

            $count=DB::select($sql);

            return response()->json(['success'=>['count'=>$count]]);
        }

}

