<div class="row option-item" data-option-item="{{$parametr->id}}">
    <div class="col-12">
        <div class="form-group d-flex align-items-center">
            <label for="check-box-{{$parametr->id}}">{{$parametr->name}}</label>
            <select class="form-control  check-render-input" id="check-box-{{$parametr->id}}" name="default_parametr[parametr][{{ $parametr->attr_type }}][{{$parametr->id}}]" style="width: 100%;">
                    <option value="true">Да</option>
                    <option value="false">Нет</option>
            </select>
            <a class="text-danger delete-product-option ml-3" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
