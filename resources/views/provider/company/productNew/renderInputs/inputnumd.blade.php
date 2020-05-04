<div class="row option-item" data-option-item="{{$parametr->id}}">
    <div class="col-12">
        <div class="form-group">
            <label for="numd-input-{{$parametr->id}}">{{$parametr->name}}</label>&nbsp;<a class="text-danger delete-product-option" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            <input type="number" id="numd-input-{{$parametr->id}}" class="form-control check-render-input" min="0" step="any" name="default_parametr[parametr][{{ $parametr->attr_type }}][{{$parametr->id}}]">
        </div>
    </div>
</div>