<div class="col-12">
    <form action="{{ asset('admin/rozetka/chats/'.$chart->id) }}" method="post" id="link-co-form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" name="type" value="{{ $chart->type }}">


        <div class="form-group">
            <label for="cancel-type">Выберите компанию для привязки чата:</label>
            <select class="form-control link-co-s2" name="company_id" id="company-id">
                @foreach($companies as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="btn-group w-100" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-success w-50" id="submit-link-co-form">принять</button>
            <button type="button" class="btn btn-danger w-50" data-dismiss="modal">отменить</button>
        </div>
    </form>
</div>



<script type="text/javascript">
    $('.link-co-s2').select2({
        placeholder: 'Компания не найдена',
        dropdownParent: $("#link-chat-to-com-modal")
    });
</script>