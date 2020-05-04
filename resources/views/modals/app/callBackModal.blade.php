<div class="modal fade" id="callBackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Мы вам перезвоним</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <form action="{{ asset('call/back/order') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="name" value="Колбек из Bigsales.pro">
                    <input type="text" class="form-control mask-tel" name="phone" placeholder="Введите телефон" autofocus required>
                    <button type="submit" class="btn btn-primary btn-custom btn-lg w-100 mt-2 mb-2">Заказать звонок</button>
                </form>
                <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>