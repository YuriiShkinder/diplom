<div class="modal-admin">

    <div style="width: 75%; overflow-y:auto;max-height: 600px;">
        @set($i,0)
@foreach($article->comments as $comment)
        <form class="editComment"  action="{{route('editComment',['comment'=>$comment->id])}}" method="post">
            @csrf
            @if($i==0)
                <span class="close"></span>
            <h4> Комментарии товара - id={{$article->id}}</h4>
                {{$i++}}
            @endif

            <ul class="admin-form">
                <li class="taxtarea-field">
                    <label for="acount">{{$comment->user->name.' '.$comment->user->last}} написал</label>
                    <div  class="input-prepend">
                        <textarea   name="text" >{{$comment->text}}</textarea>
                    </div>
                </li>

            </ul>
            <input   type="submit" name="" value="Сохранить">
        </form>
        @endforeach

    </div>
</div>