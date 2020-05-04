<div class="d-flex justify-content-center mb-3">
    <div class="order-personel-title f14 text-uppercase text-white border-radius p-1 pl-2 pr-2 shadow-custom bg-secondary">
        товары
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-4 mt-1 mb-2">
        <div class="breif-item border-radius orders-bg-light-blue p-1 pt-3 pb-3">
            <div class="order-personel-title f12 text-uppercase text-white text-nowrap border-radius mx-auto p-1 pl-2 pr-2
        shadow-custom dark-bg">
                на модерации <i class="fa fa-search text-info" aria-hidden="true"></i>
            </div>
            <div class="text-center mt-2">
                <span class="f42 text-white text-shadow">
                    {{ $poducts_info_array[0] }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 mt-1 mb-2">
        <div class="breif-item border-radius orders-bg-light-blue p-1 pt-3 pb-3">
            <div class="order-personel-title f12 text-uppercase text-white text-nowrap border-radius mx-auto p-1 pl-2 pr-2 shadow-custom dark-bg">
                на маркетплейсах <i class="fa fa-check text-success" aria-hidden="true"></i>
            </div>
            <div class="text-center mt-2">
                <span class="f42 text-white text-shadow">
                   {{ $poducts_info_array[1] }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 mt-1 mb-2">
        <div class="breif-item border-radius orders-bg-light-blue p-1 pt-3 pb-3">
            <div class="order-personel-title f12 text-uppercase text-white text-nowrap border-radius mx-auto p-1 pl-2 pr-2 shadow-custom dark-bg">
                не валидный контент <i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i>
            </div>
            <div class="text-center mt-2">
                <span class="f42 text-white text-shadow">
                    {{ $poducts_info_array[2] }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 mt-1 mb-2">
        <div class="breif-item border-radius orders-bg-light-blue p-1 pt-3 pb-3">
            <div class="order-personel-title f12 text-uppercase text-white text-nowrap border-radius mx-auto p-1 pl-2 pr-2 shadow-custom dark-bg">
                в наличии <i class="fa fa-toggle-on text-success" aria-hidden="true"></i>
            </div>
            <div class="text-center mt-2">
                <span class="f42 text-white text-shadow">
                    {{ $poducts_info_array[3] }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 mt-1 mb-2">
        <div class="breif-item border-radius orders-bg-light-blue p-1 pt-3 pb-3">
            <div class="order-personel-title f12 text-uppercase text-white text-nowrap border-radius mx-auto p-1 pl-2 pr-2 shadow-custom dark-bg">
                не в наличии <i class="fa fa-toggle-off text-danger" aria-hidden="true"></i>
            </div>
            <div class="text-center mt-2">
                <span class="f42 text-white text-shadow">
                    {{ $poducts_info_array[4] }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 mt-1 mb-2">
        <div class="breif-item border-radius orders-bg-light-blue p-1 pt-3 pb-3">
            <div class="order-personel-title f12 text-uppercase text-white text-nowrap border-radius mx-auto p-1 pl-2 pr-2 shadow-custom dark-bg">
                заблокированые <i class="fa fa-ban text-danger" aria-hidden="true"></i>
            </div>
            <div class="text-center mt-2">
                <span class="f42 text-white text-shadow">
                    {{ $poducts_info_array[5] }}
                </span>
            </div>
        </div>
    </div>
</div>