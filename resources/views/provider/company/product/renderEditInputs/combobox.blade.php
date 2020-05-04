<div class="row option-item" data-option-item="{{$parametr->id}}">
    <div class="col-12">
        <div class="form-group">
            <label for="select-combobox-{{$parametr->id}}">{{$parametr->name}}</label>&nbsp;<a class="text-danger delete-product-option"  onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            <select class="select-{{$parametr->id}} edit-select-input check-render-input" id="select-combobox-{{$parametr->id}}" name="default_parametr[parametr][{{ $parametr->attr_type }}][{{$parametr->id}}][]" style="width: 100%;">
                @foreach($values as $value)
                    @if($value->id == $p_value)
                        <option value="{{ $value->id }}" selected>{!! $value->name !!}</option>
                    @else
                        <option value="{{ $value->id }}">{!! $value->name !!}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
