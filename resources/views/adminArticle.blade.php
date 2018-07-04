@if(isset($articles) && !$articles->isEmpty())
    @foreach($articles as $article)
        <tr>
            <td>
                {{$article->id}}
            </td>
            <td>
                <a id="editArticle" href="{{route('editArticle',['aticle'=>$article->id])}}"> {{$article->title}}</a>

            </td>
            <td> {{$article->discount}}%</td>
            <td> {{$article->price}}$</td>
            <td> <p> {{str_limit($article->text,200)}}</p> </td>
            <td> <img src="{{Storage::disk('s3')->url($article->img->colection[0])}}" alt=""> </td>
            <td> {{$article->category->title}}</td>
            <td > <a class="deleteArticle" href="{{route('deleteArticle',['article'=>$article->id])}}">Удалить</a> </td>
        </tr>
    @endforeach
@endif
@if(isset($comments) && !$comments->isEmpty())
    @foreach($comments as $article)
        @if($article->comments->count()>=1)
            <tr>
                <td>{{$article->id}}</td>
                <td><a class="viewComments" href="{{route('viewComments',['articles'=>$article->id])}}">{{$article->title}}</a></td>
                <td>{{$article->comments->count()}}</td>
                <td>{{$article->category->title}}</td>
            </tr>
        @endif
    @endforeach
@endif