@if(isset($articles) && !$articles->isEmpty())
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
@endif
@if(isset($comments) && !$comments->isEmpty())
    @foreach($comments as $article)
        <tr>
            <td>{{$article->id}}</td>
            <td><a href="">{{$article->title}}</a></td>
            <td>{{$article->comments->count()}}</td>
            <td>{{$article->category->title}}</td>
        </tr>
    @endforeach
@endif