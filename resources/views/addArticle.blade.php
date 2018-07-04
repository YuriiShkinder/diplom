<div class="modal-admin">

    <div class="modal-admin-content">
    <form  action="{{isset($article)? route('editArticle',['aticle'=>$article->id]) :route('addArticle')}}" method="post" enctype="multipart/form-data">
        @csrf
        <span class="close"></span>
        <h4> {{isset($article)? 'Редактирование': 'Добавление'}} товара</h4>
        <ul class="admin-form">
            <li class="taxt-field">
                <label for="acount">Hазвание товара</label>
                <div class="input-prepend">
                    <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                    <input type="text" name="title" value="{{isset($article) ? $article->title  : old('name')}}" placeholder="Введите название товара">
                </div>
            </li>
            <li class="taxt-field">
                <label for="acount">Цена товара</label>
                <div class="input-prepend">
                    <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                    <input type="text" name="price" value="{{isset($article) ? $article->price  : old('price')}}" placeholder="Введите цену товара">
                </div>
            </li>
            <li class="taxt-field">
                <label for="acount">Скидка товара</label>
                <div class="input-prepend">
                    <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                    <input type="text" name="discount" value="{{isset($article) ? $article->discount  : old('discount')}}" placeholder="Введите цену скидки">
                </div>
            </li>
            <li class="taxtarea-field">
                <label for="acount">Описание</label>
                <div  class="input-prepend">
                    <textarea   name="text" placeholder="Введите oписание">{{isset($article) ? $article->text  : old('text')}}</textarea>
                </div>
            </li>
            <li class="taxtarea-field">
                <label for="acount">Описание full</label>
                <div  class="input-prepend">
                    <textarea   name="desc" placeholder="Введите oписание full">{{isset($article) ? $article->desc  : old('desc')}}</textarea>
                </div>
            </li>
            <li class="taxt-field">
                <label for="acount">Категория</label>
                <div class="input-prepend">
                    <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                    <select class="admin-select" name="category_id" >
                        @foreach($parentCategory as $item)
                            @if(isset($article) && $item->id == $article->category_id)
                                <option selected value="{{$item->id}}">{{$item->title}}</option>
                            @endif
                            <option value="{{$item->id}}">{{$item->title}}</option>

                        @endforeach
                    </select>
                </div>
            </li>

            <li class="taxt-field">
                <label for="acount">Бренд</label>
                <div class="input-prepend">
                    <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                    <select class="admin-select" name="brand_id" >

                        @foreach($brends as $item)
                            @if(isset($article) && $item->id == $article->brand_id)
                                <option selected value="{{$item->id}}">{{$item->name}}</option>
                            @endif
                            <option value="{{$item->id}}">{{$item->name}}</option>

                        @endforeach
                    </select>
                </div>
            </li>
            <li class="taxtarea-field">
                <label for="acount">Фото товара</label>
                    @csrf
                <div class="acount-foto">
                @if(isset($article) )

                        @foreach($article->img->colection as $item )
                        <img {{isset($article) ? 'class=editFotoArticle'  : ''}} height="100" src="{{Storage::disk('s3')->exists($item) ? Storage::disk('s3')->url($item) : ''}}" alt="foto">
                        @endforeach

                    @endif
                </div>
                    <div class="file_upload">
                        <button type="button">Выбрать</button>
                        <div>Файлы не выбраны</div>
                        <input type="file" name="img[]" multiple>
                    </div>

            </li>
            <li id="slider" class="taxtarea-field">
                <label for="acount">Фото товара для слайдера</label>
                @csrf
                <div class="acount-foto">
                    @if(isset($article) )
                            <img {{isset($article)? 'class=editSliderArticle' : ''}} height="100" src="{{Storage::disk('s3')->exists($article->img->slider) ? Storage::disk('s3')->url($article->img->slider) : ''}}" alt="foto">
                    @endif
                </div>
                <div class="file_upload">
                    <button type="button">Выбрать</button>
                    <div>Файлы не выбраны</div>
                    <input  type="file" name="slider" multiple>
                </div>

            </li>
        </ul>
        <input  type="submit" name="" value="Сохранить">
    </form>
    </div>
    </div>