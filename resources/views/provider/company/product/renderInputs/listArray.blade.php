<div class="row option-item" data-option-item="{{$parametr->id}}">
    <div class="col-12">
        <div class="form-group d-flex align-items-center">
            <label for="select-list-{{$parametr->id}}">{{$parametr->name}}</label>&nbsp;
            <select class="select-{{$parametr->id}} check-render-input w-100 select-list" id="select-list-{{$parametr->id}}" name="default_parametr[parametr][{{ $parametr->attr_type }}][{{$parametr->id}}][]" style="width: 100%;"  multiple="multiple">
                @foreach($values as $value)
                    <option value="{{ $value->id }}">{!! $value->name !!}</option>
                @endforeach
            </select>
            <a class="text-danger delete-product-option ml-3" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
        </div>
    </div>
    <script>
        $('.select-{{$parametr->id}}').select2({
            tags: false,
            //tokenSeparators: [',', ' '],
            placeholder: 'Укажите один или несколько характеристик',
            theme: 'bootstrap4'

        });

    </script>
</div>
