<div class="row option-item" data-option-item="{{$parametr->id}}">
    <div class="col-12">
        <div class="form-group d-flex align-items-center">
            <label for="text-input-{{$parametr->id}}">{{$parametr->name}}</label>&nbsp;
            <input type="text" class="form-control check-render-input" id="text-input-{{$parametr->id}}" name="default_parametr[parametr][{{ $parametr->attr_type }}][{{$parametr->id}}]">
            <a class="ml-3 text-danger delete-product-option" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
        </div>
    </div>
</div>