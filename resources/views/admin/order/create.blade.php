@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex w-100 flex-column flex-sm-row justify-content-between align-items-center f30 mt-5 mb-5">
                <div class="text-uppercase blue-d-t">
                    Содание нового заказа <i class="fa fa-cart-plus"></i>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-md-10 border-radius-50 bg-white p-4 border border-blue">
                    <form action="{{ asset('admin/orders') }}" method="POST" id="admin-create-new-order-form">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="product-id">Наименование товара*</label>
                            <select class="select2-products form-control" name="product_id" id="product-id" data-url="{{asset('admin/orders/')}}">
                                @foreach($products as $product)
                                    @if(old('marketplace_id'))
                                        <option value="{{ $product->id }}" {{(old('product_id') == $product->id)?"selected":""}}>
                                            {{ $product->name }}
                                        </option>
                                    @else
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group product-info"></div>

                        <div class="form-group">
                            <label for="marketplace-id">Маркетплейс*</label>
                            <select class="select2-marketplaces form-control" name="marketplace_id" id="marketplace-id">
                                @foreach($marketplaces as $marketplace)
                                    @if(old('marketplace_id'))
                                        <option value="{{ $marketplace->id }}" {{(old('marketplace_id') == $marketplace->id)?"selected":""}}>{{ $marketplace->name }}</option>
                                    @else
                                        <option value="{{ $marketplace->id }}" >{{ $marketplace->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Количество* <?php echo '<span class="text-danger">'.$errors->first('quantity').'</span>'; ?></label>
                            <input type="number" step="1" min="0" class="form-control {{ session('quantity')?'invalid':'' }}" id="quantity" name="quantity" placeholder="Укажите количесво (шт) ..." value="{{ old('quantity') }}">
                        </div>

                        <div class="form-group">
                            <label for="">ФИО покупателя* <?php echo '<span class="text-danger">'.$errors->first('customer_name').'</span>'; ?></label>
                            <input class="form-control" type="text" id="customer-name" name="customer_name" placeholder="ФИО покупателя"  value="{{ old('customer_name') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Эл.почта покупателя</label>
                            <input class="form-control" type="text" id="customer-email" name="customer_email" placeholder="" value="{{ old('customer_email') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Тел. покупателя</label>
                            <input class="form-control" type="text" id="customer-phone" name="customer_phone" placeholder="" value="{{ old('customer_phone') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Адрес покупателя</label>
                            <input class="form-control" type="text" id="customer-adress" name="customer_adress" placeholder="" value="{{ old('customer_adress') }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Комментарий покупателя</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Способ доставки</label>
                            <input class="form-control" type="text" id="delivery-method" name="delivery_method" placeholder="" value="{{ old('delivery_method') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Метод оплаты</label>
                            <input class="form-control" type="text" id="payment-method" name="payment_method" placeholder="" value="{{ old('payment_method') }}">
                        </div>

                        <button type="submit" class="btn btn-form btn-success shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3 submit-new-order">подтвердить</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('script2')
    <script src="{{ asset('js/pages/admin/order/create_new_order.js') }}"></script>
@endsection
