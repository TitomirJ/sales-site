@extends('provider.company.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">

            @include('provider.company.layouts.breadcrumbs')

            Страница интеграций компании!
            <form action="{{ asset('/test') }}" method="GET">
                <input type="text" class="datepicker-here" name="q" style="border-radius: 10px; background: gray; color:white; width: 300px;"/>
            </form>

        </div>
    </div>
    <script>// Инициализация
        var datapicker = $('.datepicker-here').datepicker({
            range: true,
            toggleSelected: false,
            multipleDatesSeparator:' - ',
            dateFormat: 'dd.mm.yyyy',
            multipleDates: true,
            onSelect: function(formattedDate, date, inst){
                if($('.datepicker-here').val().length > 11){
                    datapicker.blur();
                    console.log(formattedDate)
                }
            }
        })

        // Доступ к экземпляру объекта
        $('.datepicker-here').data('datepicker')

    </script>
@endsection