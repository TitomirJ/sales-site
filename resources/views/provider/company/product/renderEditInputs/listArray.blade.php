<div class="row option-item" data-option-item="{{$parametr->id}}">
    <div class="col-12">
        <div class="form-group">
            <label for="select-list-{{$parametr->id}}">{{$parametr->name}}</label>&nbsp;<a class="text-danger delete-product-option" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            <select class="select-{{$parametr->id}} edit-select-input check-render-input select-list" id="select-list-{{$parametr->id}}" name="default_parametr[parametr][{{ $parametr->attr_type }}][{{$parametr->id}}][]" style="width: 100%;" multiple="multiple">
                @foreach($values as $value)
                    @if(in_array($value->id, $p_value))
                        <option value="{{ $value->id }}"  selected>{{ preg_replace("/<img[^>]+\>/i", "", $value->name) }}</option>
                    @else
                        <option value="{{ $value->id }}">{{  preg_replace("/<img[^>]+\>/i", "", $value->name)  }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <script>
        $('.select-{{$parametr->id}}').select2({
            tags: false,
            placeholder: 'Укажите один или несколько характеристик',
            theme: 'bootstrap4'

        });

    </script>

</div>
