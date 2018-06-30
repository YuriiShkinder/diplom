<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\AcountRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AcountController extends SiteController
{
   public function __construct(OrderRepository $orderRepository,UserRepository $userRepository)
   {
       parent::__construct(new CategoryRepository(new Category()));
       $this->order_rep=$orderRepository;
       $this->user_rep=$userRepository;
       $this->template='article';
       $this->title='Acount';
   }

   public function index(){
        $user=\Auth::user()->load(['orders.article.category','comments']);
        $comments=$user->comments->load(['article.category','likes'])->groupBy('article_id');

       $content=view('acount')->with([
            'user'=>$user,
            'comments'=>$comments,
       ])->render();
       $this->vars=array_add($this->vars,'content',$content);

       return $this->renderOutput();
   }

    public function edit(AcountRequest $request){

        $user=\Auth::user();
        $data=$request->except('_token');
        if($user->update($data)){
            return back()->with('status','Все ок');
        }
    }

    public function editFoto(Request $request){

        $user=\Auth::user();
        $s3 = \Storage::disk('s3');
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $name=str_random(8).'.jpg';
                $filepath = "users/".$name;
                $s3->delete($user->img);
                $s3->put($filepath,file_get_contents($image), 'public');
            }
        }
        if ($user->update(['img'=>$filepath])) {
            return response()->json(['href'=>$s3->url($filepath)]);
        }

    }

    public function editPass(Request $request){
        $user=\Auth::user();
        $rules=['password'=>'required|min:6'];
        $data=json_decode($request->get('data'));
        $arr=[];

        foreach ($data as $item){
            if($item->name === 'password'){
                $arr[$item->name]=$item->value;
            }
        }

        $validator=Validator::make($arr,$rules);

        if($validator->fails()){
            return Response::json(['success'=>false]);
        }

        $pass['password']= Hash::make(  $arr['password']);

        if($user->update($pass)){
            return Response::json(['success'=>true]);
        }
    }

}
