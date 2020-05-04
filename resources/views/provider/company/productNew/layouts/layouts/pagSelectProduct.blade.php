<form action="{{ asset('/company/usetting/pag') }}" method="POST">
    {{ csrf_field() }}
    <select class="custom-select cu-select change-pag-set-user pt-0 pb-0" id="" style="width: auto" name="pag_set_user">
        @if(Auth::user()->usetting->n_par_1 == 10)
            <option value="10" selected>10</option>
        @else
            <option value="10">10</option>
        @endif

        @if(Auth::user()->usetting->n_par_1 == 100)
            <option value="100" selected>100</option>
        @else
            <option value="100">100</option>
        @endif

        @if(Auth::user()->usetting->n_par_1 == 250)
            <option value="250" selected>250</option>
        @else
            <option value="250">250</option>
        @endif

        @if(Auth::user()->usetting->n_par_1 == 500)
            <option value="500" selected>500</option>
        @else
            <option value="500">500</option>
        @endif

    </select>
</form>
