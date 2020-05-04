<div class="row option-item" data-option='{{ $rend_key }}'>
    <div class="col-12">
        <div class="form-group d-flex align-items-center">
            <label>{{ $rend_key }}.</label>&nbsp;
            <input type="text" class="form-control check-render-input" name="your_self_parametr[parametr][{{ $rend_key }}]" value="{{ $rend_value }}">
            <a class="text-danger delete-product-option ml-3" onclick="event.preventDefault();$(this).parents('.option-item').remove();" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
        </div>
    </div>
</div>