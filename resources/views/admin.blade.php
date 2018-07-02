<ul id="admin">
    <li>  <a class="admin-active" href="">Категории товаров</a>
        @if($categories && !$categories->isEmpty())
        <div style="display:block" class="admin-content">
            <div class="admin-container">
                <div style="width: 100%" class="admin-articles">
                    <table>
                        <thead>
                        <tr>
                            <td>Заголовок</td>
                            <td>Псевдоним</td>
                            <td>parent_id</td>
                            <td>Дествие</td>
                        </tr>
                        </thead>
                        @foreach($categories as $item)
                            <tr>
                                <td>
                                    <a class="editCategory" href="{{route('editCategory',['category'=>$item->alias])}}">{{$item->title}}</a>
                                </td>
                                <td>{{$item->alias}}</td>
                                <td>{{$item->parent_id}}</td>
                                <td > <a class="removeCategory" href="{{route('deleteCategory',['category'=>$item->alias])}}">Удалить</a> </td>
                            </tr>
                        @endforeach

                    </table>


                </div>
            </div>
            <a class="modal-submit" href="{{route('addCategory')}}">Добавить категорию</a>
        </div>
            @else
            <p>
                Нет категории
            </p>
            @endif
    </li>
    <li>   <a href="#">Товары</a>
        @if($articles && !$articles->isEmpty())
        <div  class="admin-content">
            <div class="admin-container">

                    <form class="filter-form" action="{{route('articleFilter')}}" method="post">
                    @csrf
                    <ul class="filter">
                        @foreach($categories as $item)
                            @if($item->parent_id==0)
                                <li>
                                    <p>{{$item->title}}</p>
                                    <ul class="subfilter">
                                        @foreach($categories->where('parent_id',$item->id) as $sub)
                                            <li>
                                                <div class="filter-checkbox adminCheck">
                                                    <span ></span>
                                                    <span>{{$sub->title}}</span>
                                                </div>
                                                <input type="checkbox" name="{{$sub->id}}" value="0">
                                            </li>

                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                            <li>
                                <p>Price</p>
                                <div class="price_filter">
                                    <div id="range">
                                        <div class="range-input">
                                            <input data='min' type="text" name="min" value="0">
                                            <span>-</span>
                                            <input data='max'  type="text" name="max" value="{{$articles->max('price')}}">
                                        </div>

                                        <div id="first-range">
                                            <div id="middle-range">
                                                <div id="left-val"></div>
                                                <div id="right-val"></div>

                                            </div>
                                            <span>0</span>
                                            <span>{{$articles->max('price')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        <li><input type="submit" name="" value="Применить"></li>
                    </ul>
                </form>
                <div class="admin-articles">
                    <table>
                        <thead>
                        <tr>
                            <td>id</td>
                            <td>Заголовок</td>
                            <td>discount</td>
                            <td>Цена</td>
                            <td>Текст</td>
                            <td>Изображение</td>
                            <td>Категория</td>
                            <td>Дествие</td>
                        </tr>
                        </thead>
                        @foreach($articles as $article)
                        <tr>
                            <td>
                                {{$article->id}}
                            </td>
                            <td>
                                <a href="#"> {{$article->title}}</a>
                            </td>
                            <td> {{$article->discount}}%</td>
                            <td> {{$article->price}}$</td>
                            <td> <p> {{str_limit($article->text,200)}}</p> </td>
                            <td> <img src="{{Storage::disk('s3')->url($article->img->colection[0])}}" alt=""> </td>
                            <td> {{$article->category->title}}</td>
                            <td > <a href="#">Удалить</a> </td>
                        </tr>
                        @endforeach

                    </table>


                </div>
            </div>
            @if($articles instanceof \Illuminate\Pagination\LengthAwarePaginator)
                @if(  $articles->lastPage() >= 3)
                    <ul class="pagination pagination-catalog admin-pag">
                        @if ($articles->currentPage() !== 1)
                            <li> <a class="first-page"  href="{{ $articles->url(($articles->currentPage()-1)) }}"></a></li>
                        @endif

                        @if ($articles->currentPage() == 1)
                            <li> <a class="admin-active" href="{{$articles->url(1)}}"> 1 </a></li>

                        @endif

                        <li id="pagination-page"><a href="#">...</a>
                            <ul class="subpagin">
                                @for ($i = 2; $i < $articles->lastPage(); $i++)

                                    @if ($articles->currentPage() == $i)
                                        <li> <a class="admin-active">{{ $i }}</a></li>
                                    @else
                                        <li> <a href="{{ $articles->url($i) }}">{{ $i }}</a></li>
                                    @endif

                                @endfor
                            </ul>
                        </li>

                        @if ($articles->currentPage() == $articles->lastPage()-1)
                            <li> <a class="admin-active">{{ $articles->lastPage()-1}}</a></li>
                        @else
                            <a href="{{ $articles->url($articles->lastPage()-1) }}">{{$articles->lastPage()-1}}</a>
                        @endif
                        @if ($articles->currentPage() == $articles->lastPage())
                            <li>  <a class="admin-active">{{ $articles->lastPage() }}</a></li>
                        @endif

                    </ul>
                @elseif($articles->lastPage() >1 && $articles->lastPage() < 4)
                    <ul class="pagination pagination-catalog">
                        @if ($articles->currentPage() !== 1)
                            <li> <a class="first-page"  href="{{ $articles->url(($articles->currentPage()-1)) }}"></a></li>
                        @endif

                        @if ($articles->currentPage() == 1)
                                <a href="{{ $articles->url(1) }}">1</a>
                        @endif

                        @if ($articles->currentPage() == 2)
                            <li> <a class="admin-active">{{ 2 }}</a></li>
                        @else
                            <a href="{{ $articles->url(1) }}">2</a>
                        @endif
                        @if ($articles->currentPage() == $articles->lastPage())
                            <li>  <a class="admin-active">{{ $articles->lastPage() }}</a></li>
                        @endif

                    </ul>
                @endif

            @endif
            <a class="modal-submit" href="{{route('addArticle')}}">Добавить товар</a>
        </div>
        @else
            <p>
                Нет товаров
            </p>
        @endif
    </li>
    <li >  <a href="#">Отзывы</a>
        @if($comments && !$comments->isEmpty())
        <div  class="admin-content">
            <div class="admin-container">
                <div style="width: 100%" class="admin-articles">
                    <table>
                        <thead>

                        <tr>
                            <td>id</td>
                            <td>Товар</td>
                            <td>Количество отзывов</td>
                            <td>Категории</td>
                        </tr>

                        </thead>
                        <tbody>
                        @foreach($comments as $article)
                        <tr>
                            <td>{{$article->id}}</td>
                            <td><a href="">{{$article->title}}</a></td>
                            <td>{{$article->comments->count()}}</td>
                            <td>{{$article->category->title}}</td>
                        </tr>

                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            @if($comments instanceof \Illuminate\Pagination\LengthAwarePaginator)
                @if(  $comments->lastPage() >= 3)
                    <ul class="pagination pagination-catalog  admin-pag">
                        @if ($comments->currentPage() !== 1)
                            <li> <a class="first-page"  href="{{ $comments->url(($comments->currentPage()-1)) }}"></a></li>
                        @endif

                        @if ($comments->currentPage() == 1)
                            <li> <a class="admin-active" href="{{$comments->url(1)}}"> 1 </a></li>

                        @endif

                        <li id="pagination-page"><a href="#">...</a>
                            <ul class="subpagin">
                                @for ($i = 2; $i < $comments->lastPage(); $i++)

                                    @if ($comments->currentPage() == $i)
                                        <li> <a class="admin-active">{{ $i }}</a></li>
                                    @else
                                        <li> <a href="{{ $comments->url($i) }}">{{ $i }}</a></li>
                                    @endif

                                @endfor
                            </ul>
                        </li>

                        @if ($comments->currentPage() == $comments->lastPage()-1)
                            <li> <a class="admin-active">{{ $comments->lastPage()-1}}</a></li>
                        @else
                            <a href="{{ $comments->url($comments->lastPage()-1) }}">{{$comments->lastPage()-1}}</a>
                        @endif
                        @if ($comments->currentPage() == $comments->lastPage())
                            <li>  <a class="admin-active">{{ $comments->lastPage() }}</a></li>
                        @endif

                    </ul>
                @elseif($comments->lastPage() >1 && $comments->lastPage() < 4)
                    <ul class="pagination pagination-catalog">
                        @if ($comments->currentPage() !== 1)
                            <li> <a class="first-page"  href="{{ $comments->url(($comments->currentPage()-1)) }}"></a></li>
                        @endif

                        @if ($comments->currentPage() == 1)
                            <a href="{{ $comments->url(1) }}">1</a>
                        @endif

                        @if ($comments->currentPage() == 2)
                            <li> <a class="admin-active">{{ 2 }}</a></li>
                        @else
                            <a href="{{ $comments->url(1) }}">2</a>
                        @endif
                        @if ($comments->currentPage() == $comments->lastPage())
                            <li>  <a class="admin-active">{{ $comments->lastPage() }}</a></li>
                        @endif

                    </ul>
                @endif

            @endif
        </div>
        @else
            <p>
                Нет комментов
            </p>
        @endif
    </li>
    <li >  <a href="#">Пользователи</a>
        @if($users && !$users->isEmpty())
        <div  class="admin-content">
            <div class="admin-container">
                <div style="width: 100%" class="admin-articles">
                    <table>
                        <thead>
                        <tr>
                            <td>id</td>
                            <td>Photo</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Login</td>
                            <td>Role</td>
                            <td>Delete</td>
                        </tr>
                        </thead>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                {{$user->id}}
                            </td>
                            <td> <img src="{{ Storage::disk('s3')->exists($user->img) ? Storage::disk('s3')->url($user->img) : $user->img }}" alt=""> </td>
                            <td>
                                {{$user->name.' '.$user->last}}
                            </td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->login}}</td>
                            <td>
                                @if(!$user->roles->isEmpty())
                                    @foreach($user->roles as $role)
                                        <p>{{$role->name}}</p><br>
                                        @endforeach
                                    @endif
                            </td>
                            <td > <a class="deleteUser" href="{{route('deleteUser',['user'=>$user->login])}}">Удалить</a> </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
        @endif
    </li>

</ul>