<div class="row option-item" data-option-item="{{$parametr->id}}">
    <div class="col-12">
        <div class="form-group d-flex align-items-center">
            <label for="numd-input-{{$parametr->id}}">{{$parametr->name}}</label>
            <input type="number" id="numd-input-{{$parametr->id}}" class="form-control check-render-input" min="0" step="any" name="default_parametr[parametr][{{ $parametr->attr_type }}][{{$parametr->id}}]">
            <a class="text-danger delete-product-option ml-3" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
        </div>
    </div>
</div>