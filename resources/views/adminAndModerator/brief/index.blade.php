@extends('admin.layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid mt-5">
            <div class="alert alert-primary" role="alert">
                <img src="https://esputnik.com/es/login/69fdb632da3d6335eccd89a872318822.png" alt="E-sputnic baner" style="height: 30px;"> Баланс СМС рассылки: {{ $bal_esputnik->currentBalance }} грн.
            </div>
            {{--<a href="viber://chat?number=+380975926506">viber</a>--}}
            {{--<br>--}}
            {{--<a href="tg://resolve?domain=TimOrTamerlan">Telegram_bot</a>--}}
            {{--<br>--}}
            {{--<a href="whatsapp://send?phone=380500680718&text=">WhatsApp</a>--}}
            {{--<a href="whatsapp://send?phone=380975926506&text=">WhatsApp</a>--}}
            {{--<br>--}}
            {{--<a href="http://m.me/TiMorTamerlaN">Facebook</a>--}}
            {{--<a href="http://m.me/100017222829531">Facebook</a>--}}



            {{--<table class="table position-relative guest-table scroll_me">--}}
                {{--<thead>--}}
                {{--<tr class="tb-head text-uppercase blue-d-t text-center">--}}
                    {{--@foreach($headings as $h)--}}
                        {{--<th scope="col" class="h-60">--}}
                            {{--<div class="d-block p-3 h-100 border-top border-bottom border-blue text-nowrap">--}}
                                {{--{{ $h }}--}}
                            {{--</div>--}}
                        {{--</th>--}}
                    {{--@endforeach--}}
                {{--</tr>--}}
                {{--</thead>--}}

                {{--<tbody id="guest-place" class="table-bg">--}}
                {{--@foreach($resault as $col)--}}
                    {{--<tr class="text-center bor-bottom">--}}
                        {{--@for($i = 0; $i < count($headings); $i++)--}}
                        {{--<td class="font-weight-bold">--}}
                            {{--{{ $col->$headings[$i] }}--}}
                        {{--</td>--}}
                        {{--@endfor--}}
                    {{--</tr>--}}
                {{--@endforeach--}}


                {{--</tbody>--}}
            {{--</table>--}}
        </div>
    </div>





@endsection

@section('script2')

@endsection

