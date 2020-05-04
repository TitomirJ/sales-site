<div class="row option-item" data-option-item="{{$parametr->id}}">
    <div class="col-12">
        <div class="form-group d-flex align-items-center">
            <label for="num-input-{{$parametr->id}}">{{$parametr->name}}</label>&nbsp;
            <input type="number" id="num-input-{{$parametr->id}}" class="form-control check-render-input" min="0" name="default_parametr[parametr][{{ $parametr->attr_type }}][{{$parametr->id}}]">
            <a class="text-danger delete-product-option ml-3" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
        </div>
    </div>
</div>