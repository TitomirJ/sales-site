<div class="carousel-item {{ ($i == 0)? ' active ': ' ' }} w-100">
    <div class="row">

        <div class="col-12 col-md-6 d-flex flex-column justify-content-end pb-5 slider-item h-100">

            <div class="d-block d-md-none img-wrapper mt-3">
                <img src="{{asset('/public/images/quotes.png')}}" alt="quotes" height="70px">
            </div>

            <div class="d-flex justify-content-center align-items-center h-100">
                <p class="text-slider font-s6 mb-0 pb-3  mt-5" style="font-style: italic; ">
                    {{ $reviews[$i]['text'] }}
                </p>
            </div>

        </div>

        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center">
            <img class="d-block w-100" src="{{asset($reviews[$i]['image_path'])}}" alt="{{ $reviews[$i]['label'] }}" style="width: 100%;">
        </div>

    </div>
</div>
