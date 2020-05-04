<!-- Logout Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Уже уходите?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Нажмите "Выйти" если закончили работу.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Отмена</button>
                <a  class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Выйти
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-center">
                <h5 class="modal-title w-100 text-white">Внимание!</h5>
            </div>
            <div class="modal-body">
                <p class="confirm-modal-info w-100 text-center"></p>
            </div>
            <div class="modal-footer">
                <form class="confirm-modal-form" method="GET" action="">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg  mt-2 mb-3 on-overlay-loader">Подтвердить</button>
                </form>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editAndCreateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-center">

            </div>
            <div class="modal-body editAndCreateModal-body">

            </div>
        </div>
    </div>
</div>