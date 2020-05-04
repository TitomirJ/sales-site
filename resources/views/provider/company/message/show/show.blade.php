@extends('provider.company.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/checkbox.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/pages/messages/msg_provider.css') }}">
@endsection

@section('script1')

@endsection


@section('content')

    <div class="content-wrapper">
        <div class="container-fluid mt-5">

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    @if($chart->type == '0')
                        <?
                            $orders_ids_array = json_decode($chart->orders_ids);
                            $orders_ids_string = implode(", ", $orders_ids_array);
                        ?>
                        @if(count($orders_ids_array) == 1)
                            Вопрос по заказу № {{ $orders_ids_string }}
                        @else
                            Вопрос по заказам № {{ $orders_ids_string }}
                        @endif

                    @elseif($chart->type == '1')
                        Вопрос по товару
                    @elseif($chart->type == '2')
                        {{ $chart->subject }}
                    @endif
                </div>
            </div>


            @if($chart->type == '1')
                <?
                $gallery_array = json_decode($chart->product->gallery);
                ?>
            <div class="row m-3">
                <div class="col-10 offset-1 p-4" style="border: gray solid 2px;">
                    <div class="row h-100">
                        <div class="col-sm-2">
                            <img class="w-100" src="{{$gallery_array[0]->public_path}}" alt="{{$chart->product->name}}">
                        </div>
                        <div class="col-sm-10">
                            <p style="font-size: 24px;">
                                <a target="_blank" href="{{ asset('company/products/'.$chart->product->id) }}">{{ $chart->product->name }}</a>
                            </p>
                            <p class="badge badge-primary" style="font-size: 36px;">
                               {{ $chart->product->price }}<span style="font-size: 18px;">грн.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="wrapper row">
                <section class="chat p-r">
                    <div class="chat__position" id="messages-place">

                        @include('provider.company.message.show.layouts.messagesItem')

                    </div>

                    @if($chart->receiver->email != null)
                        <div class="wrapper-checkbox p-2 chat w-100">
                            <input id="send-email" type="checkbox" name="send_email" value="1" class="css-checkbox " form="send-new-message">
                            <label for="send-email" class="ml-2 form-check-label css-label">&nbsp;&nbsp;&nbsp;Отправить сообщение покупателю на почту?</label>
                        </div>
                    @endif

                    <div class="text-massage p-1">

                        <form action="{{ asset('company/messages') }}" method="post" id="send-new-message">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $chart->id }}">
                            <input type="hidden" name="m_id" value="{{ $chart->m_id }}">
                            @if($chart->type == '0')
                                <input type="hidden" name="m_order_id" value="{{ $chart->m_order_id }}">
                            @endif
                            <input type="hidden" name="receiver_id" value="{{ $chart->m_user_id }}">
                        </form>
                        <textarea name="body" placeholder="Текст сообщения..." form="send-new-message" id="message-body" style="height: 100px;"></textarea>
                        <a class="btn-massage" id="send-msg-btn">
                            <img src="{{ asset('images/icons8-sent-40.png') }}">
                        </a>

                    </div>

                </section>
            </div>
        </div>
    </div>
@endsection

@section('script2')
    <script>
        $('#messages-place').stop().animate({
            scrollTop: $('#messages-place')[0].scrollHeight
        }, 800);
        $('#send-msg-btn').on('click', function (e) {
            e.preventDefault();
            var inProgress = false;
            var form = $('#send-new-message');

            var url = form.attr('action')+'?'+form.serialize();
            var method = form.attr('method');
            var bodyMSG = $('#message-body').val();

            if(bodyMSG == ''){
                $.toaster({ message : "Заполните поле \"Текст сообщения...\"!", title : '', priority : 'warning', settings : {'timeout' : 6000} });
            }else{
                if(!inProgress){
                    $.ajax({
                        async: true,
                        method: method,
                        url: url,
                        beforeSend: function() {
                            inProgress = true;
                            $('#overlay-loader').show();
                        },
                        success: function(data){
                            var data = $.parseJSON( data );
                            if(data.status == 'success'){
                                $('#messages-place').html(data.render);
                                $('#messages-place').stop().animate({
                                    scrollTop: $('#messages-place')[0].scrollHeight
                                }, 800);
                            }

                            $.toaster({ message : data.msg, title : '', priority : data.status, settings : {'timeout' : 3000} });
                            $('#overlay-loader').hide();
                        },
                        error: function(){
                            $.toaster({ message : "Ошибка сервера!", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
                            $('#overlay-loader').hide();
                        }
                    });
                }
            }
        });


    </script>
@endsection