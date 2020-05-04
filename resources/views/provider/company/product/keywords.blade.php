@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/pages/showProduct/showProduct.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">

              <div class="col-12  mt-5 mb-5">
                <div class=" blue-d-t">
                    <p class="text-uppercase f30"> Добавление слов для поиска продукта на маркетплэйсах</p>
                </div>
                <div class="wrap_item d-flex justify-content-between">
                    <div>
                         <?
                         $gallery_array = json_decode($item->gallery);
                         ?>
                         <img src="{{$gallery_array[0]->public_path}}" alt="{{$item->name}}" style="max-width: 100px;">
                     
                     </div>
                     <p class="text-center">{{$item->name}}</p> 
                    
                      </div>
              </div>
              <span class="text-center m-2">Подкатегория: {{$item->subcategory->name}}</span>
            </div>  
            <hr>
            <div class="row">
                <div class="col-12">
                    <p>
                        Дополнительные слова, такие как: купить, заказать и регион, добавляются автоматически.<br>
                        Для добавления поискового ключа для продукта укажите в поле одно слово (или короткую фразу) используя только буквы или сочетание букв и цифр.<br>
                        Допускается использовать пробел между словами в одной фразе. Max кол-во слов во фразе: 5 шт. <br>
                        Пример:<span class="btn btn-success ml-1">слово</span> или <span class="btn btn-success">слово слово</span></p>
                        <p>Указав слово, по которому будет осуществляться поиск, нажмите на кнопку <span class="btn btn-success ml-1">&#43;</span>
                        справа от поля ввода. Слово будет сохранено автоматически.
                    </p>
                    <span class="bg-warning ">                  
                        Нажав (кликнув) на слове или фразе Вы удалите это слово.
                    </span>
                    <form action="" method="POST" id="form_add_words">
                        {{ csrf_field() }}
                        <div class="add_key text-center">
                            <label for="input_add_words" class="font-italic text-primary">Поле для ввода поискового слова или фразы</label>
                            <input type="text" name="key_word_user" id="input_add_words">
                            <input type="hidden" name="id_item" value="{{$item->id}}" id="id_item_add_word">
                            <span class="btn btn-success" id="btn_add_keyword">&#43;</span>
                        </div>
                    </form>
               
                <hr>
               <p>
                   Поисковые слова для продукта :
               </p>
                <div class="words_wrap" id="words_add_user">
                        
                    @if($item->words)
                    @foreach(json_decode($item->words) as $word)
                <span class="key_word_from_user btn btn-success m-2" data-num="wk">{{$word}}</span>
                    @endforeach
                    @endif
                </div>
                <hr>
                {{-- блок управления редактирования ключевых слов --}}
                <div class="wrap_block_edit_words d-flex justify-content-end">
                <div class="wrap_instrumental_words d-flex flex-wrap">
                    <div class="del_keywords m-2">
                    <form action="{{ route('alldelwords') }}" method="POST">
                        {{ csrf_field() }}
                            <input type="hidden" name="id_item" value="{{$item->id}}" >
                            <button class="btn btn-danger" type="submit">Очистить товар</button>
                        </form>
                    </div>

                    <div class="wrap_button_add_words_on_subcategory m-2"> 
                        <form action="{{ route('addinsubcatwords') }}" method="POST">
                            {{ csrf_field() }}            
                        <button type="submit" class="btn btn-info" id="add_subcat_words">
                            Привязать к подкатегории
                        </button> 
                    </form>                                            
                    </div>
                    <div class="wrap_button_add_words_on_subcategory m-2 "> 
                        <form action="{{ route('delsubcatwords') }}" method="POST">
                            {{ csrf_field() }}            
                        <button type="submit" class="btn btn-warning" id="del_subcat_words">
                            Очистить подкатегорию
                        </button> 
                    </form>                                            
                    </div>
                </div>
            </div>              
                <hr>

            </div>
     
            </div>
              
        

             
            
            </div>

        </div>
    </div>

@endsection

@section('script2')
    <!-- Add keywords -->
    <script src="{{asset('js/pages/provider/product/add_keywords.js')}}"></script>
@endsection