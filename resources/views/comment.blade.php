
@foreach($items as $item)

        <li>
            <div id="{{$item->id}}" class="comment_block">
                <div class="comment_wrap">
                    <div class="user_info">
                        <div class="user_image">
                            <img src="{{ Storage::disk('s3')->exists($item->user->img) ? Storage::disk('s3')->url($item->user->img) : $item->user->img }}" alt="">
                        </div>
                        <div class="user_nick">
                            <p>{{$item->user->name.' '.$item->user->last}}</p>
                        </div>
                    </div>
                    <div class="comment">
                        <div class="comment_header">
                            <div class="comment_date">{{is_object($item->created_at) ? $item->created_at->format('F d, Y  \a\t H:i') : '' }}</div>
                            <div class="comment_number">#</div>
                        </div>
                        <div class="comment_body">
                            <p>{{$item->text}}</p>
                        </div>
                        <div  class="comment_footer">

                            <div href="{{route('likeComment',['comment'=>$item->id])}}" class="assessment {{Auth::user()? 'clickLikeComment' : ''}}">
                                <div {!!  \Auth::user() && $item->likes()->where([['user_id',\Auth::user()->id],['like','1']])->get()->count()>0 ? 'style= "border: 1px solid black; border-radius: 5px "' : '' !!} class="like"><i class="fa fa-thumbs-up"></i><span class="sum"> {{$item->likes->where('like','1')->sum('like')}} </span></div>
                                <div {!! \Auth::user() && $item->likes()->where([['user_id',\Auth::user()->id],['like','-1']])->get()->count()>0 ? 'style= "border: 1px solid black ; border-radius: 5px"' : '' !!} class="dislike"><i class="fa fa-thumbs-down"></i><span class="sum2"> {{$item->likes->where('like','-1')->sum('like')}} </span></div>
                            </div>
                            @auth()
                            <button class="reply">Ответить <i class="fa fa-reply"></i></button>
                             @endauth

                        </div>
                    </div>
                </div>
            </div>
            @if(isset($comments[$item->id]))
                <ul class="children">
                    @include('comment',['items'=>$comments[$item->id]])
                </ul>
            @endif
        </li>



@endforeach
