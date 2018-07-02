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