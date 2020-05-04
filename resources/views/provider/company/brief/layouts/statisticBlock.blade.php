<div class="d-flex justify-content-center mb-3">
  <div class="order-personel-title f14 text-uppercase text-white border-radius p-1 pl-2 pr-2 shadow-custom bg-secondary">
    Заказы
  </div>
</div>

<div class="w-100 d-flex flex-column align-items-center mb-2 mt-2">

  <div class="breif-item new-orders border-radius orders-bg-light-blue shadow-custom text-center w-100 m-1 p-3">
    <div class="new-orders-title text-left f10 font-weight-bold text-uppercase">Новые заказы</div>
    <div class="new-orders-count f72 text-white mb-3 text-shadow">
      {{$count_new_orders}}
    </div>
  </div>

  <div class="orders-wrapper d-flex w-100">

    <div class="breif-item completed-orders border-radius orders-bg-dark-blue shadow-custom text-center mt-1 mr-1 p-3 w-50">

      <div class="completed-orders text-left f10 font-weight-bold text-uppercase">
        Выполненные заказы
      </div>

      <div class="completed-order f72 text-white text-shadow">
        {{$count_ended_orders}}
      </div>

    </div>

    <div class="breif-item canceled-orders border-radius orders-bg-light-grey shadow-custom text-center mt-1 ml-1 p-3 w-50">
      <div class="canceled-orders text-left f10 font-weight-bold text-uppercase">
        Отмененные заказы
      </div>
      <div class="canceled-orders f72 text-white text-shadow">
        {{$count_deleted_orders}}
      </div>
    </div>

  </div>

</div>
