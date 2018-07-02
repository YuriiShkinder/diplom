<div class="modal-admin">
    <div class="modal-admin-content">

    <form action="{{isset($category)? route('editCategory',['category'=>$category->alias]) :route('addCategory')}}" method="post">
        @csrf
        <span class="close"></span>
        <h4> {{isset($category)? 'Редактирование': 'Добавление'}} категории</h4>
        <ul class="admin-form">
            <li class="taxt-field">
                <label for="acount">Hазвание категории</label>
                <div class="input-prepend">
                    <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                    <input type="text" name="title" value="{{isset($category) ? $category->title  : old('name')}}" placeholder="Введите название категории">
                </div>
            </li>
            <li class="taxt-field">
                <label for="acount">Псевдоним категории</label>
                <div class="input-prepend">
                    <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                    <input type="text" name="alias" value="{{isset($category) ? $category->alias  : old('alias')}}" placeholder="Введите псевдоним категории">
                </div>
            </li>
            <li class="taxt-field">
                <label for="acount">Заголовок</label>
                <div class="input-prepend">
                    <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                    <select class="admin-select" name="parent_id" >
                        @if(!isset($category) )
                            <option >0</option>
                        @endif

                        @foreach($parentCategory as $item)
                            @if(isset($category) && $item->id == $category->parent_id)
                                <option selected value="{{$item->id}}">{{$item->title}}</option>
                            @endif
                                <option value="{{$item->id}}">{{$item->title}}</option>

                        @endforeach
                    </select>
                </div>
            </li>

        </ul>
        <input  type="submit" name="" value="Сохранить">
    </form>
</div>
    </div>