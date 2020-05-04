<div class="container-fluid">
    <div class="row font-weight-bold">

        <div class="col-6">
            <div class="f30">
                Заказ № {{$order->id}}
            </div>
        </div>

        <div class="col-6">
            <div class="text-right f18">
                ТТН: @if($order->ttn == '' || $order->ttn == null) не указан
                @else
                    {{$order->ttn}}
                @endif
                @if($order->company_id == 12)
                    <br>
                    <a class="btn btn-primary show-edit-order-pr-modal" data-url="{{ asset('company/orders/'.$order->id.'/edit_order_info') }}">
                        Launch demo modal
                    </a>
                @endif
            </div>
        </div>

    </div>

    <div class="row bor-bottom pb-4">

        <div class="col-6 d-flex">

            <div>
                <div class="d-flex align-items-center justify-content-center h-100">
                    <img src="{{asset($order->marketplace->image_path)}}" alt="{{$order->marketplace->name}}" width="80">
                </div>
                <div class="font-weight-bold">
                    {{$order->created_at}}
                </div>
            </div>

            <div class="ml-5 d-flex align-items-center f18">
                Marketplace {{$order->marketplace->name}}
            </div>

        </div>

    </div>

    <div class="row bor-bottom pb-3">

        @if($company->block_new == '1' || $company->block_bal == '1')
            <div class="col-4 f18">
                <div class="font-weight-bold text-uppercase pt-3 pb-3">
                    клиент:
                </div>
                @if($company->block_new == 1)

                    <div>
                        Вы находитесь в тестовом периоде<br>
                        Информация недосутпна
                    </div>

                @elseif($company->block_bal == 1)

                    <div>
                        Ваш баланс ниже лимита<br>
                        Информация недосутпна
                    </div>

                @elseif($company->block_new == 1 && $company->block_bal == 1)

                    <div>
                        Вы находитесь в тестовом периоде<br>
                        Ваш баланс ниже лимита<br>
                        Информация недосутпна
                    </div>
                @endif
            </div>

            <div class="col-4 f18">
                <div class="font-weight-bold text-uppercase pt-3 pb-3">
                    адрес доставки:
                </div>
                @if($company->block_new == 1)

                    <div>
                        Вы находитесь в тестовом периоде<br>
                        Информация недосутпна
                    </div>

                @elseif($company->block_bal == 1)

                    <div>
                        Ваш баланс ниже лимита<br>
                        Информация недосутпна
                    </div>

                @elseif($company->block_new == 1 && $company->block_bal == 1)

                    <div>
                        Вы находитесь в тестовом периоде<br>
                        Ваш баланс ниже лимита<br>
                        Информация недосутпна
                    </div>
                @endif
            </div>
        @else
            <div class="col-4 f18">
                <div class="font-weight-bold text-uppercase pt-3 pb-3">
                    клиент:
                </div>
                <div>
                    ФИО:
                    {{$order->customer_name}}<br>
                    <div class="pt-2 pb-2">
                        E-mail:
                        @if($order->customer_email == null)
                            не указан
                        @else{{$order->customer_email}}
                        @endif
                    </div>
                    <div>
                        Телефон:
                        @if($order->customer_phone == null)
                            не указан
                        @else{{$order->customer_phone}}
                        @endif
                    </div>
                    <div class="pt-2">
                        <b>Способ оплаты:</b>
                        @if($order->payment_method == null)
                            не указан
                        @else{{$order->payment_method}}
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-4 f18">
                <div class="font-weight-bold text-uppercase pt-3 pb-3">
                    адрес доставки:
                </div>

                @if($order->delivery_method == '' || $order->delivery_method == null)
                @else
                    {{$order->delivery_method}},
                @endif

                @if($order->customer_adress == '' || $order->customer_adress == null)
                @else
                    {{$order->customer_adress}},
                @endif
                <br>
                {{$order->customer_name}}
            </div>

        @endif

        <div class="col-4 f18">

            <div class="font-weight-bold text-uppercase pt-3 pb-3">
                товары:
            </div>

            <?
            $g = json_decode($order->product->gallery);
            ?>

            <div class="d-flex align-items-center pl-2 pb-4">
                <img src="{{$g[0]->public_path}}" alt="{{$order->name}}" width="50">
                <div class="pl-2 font-weight-bold">
                    {{$order->product->name}}
                </div>
            </div>

            <div class="font-weight-bold text-uppercase pt-3 pb-3">
                коментарий:
            </div>

            <textarea name="comments" class="textarea-custom w-100" maxlength="1500">{{$order->comment}}</textarea>

        </div>

    </div>
</div>
