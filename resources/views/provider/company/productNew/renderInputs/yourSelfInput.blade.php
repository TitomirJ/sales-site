<div class="row option-item" data-option='{{ $rend_key }}'>
    <div class="col-12">
        <div class="form-group">
            <label>{{ $rend_key }}</label>&nbsp;<a class="text-danger delete-product-option" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            <input type="text" class="form-control check-render-input" name="your_self_parametr[parametr][{{ $rend_key }}]" value="{{ $rend_value }}">
        </div>
    </div>
</div>