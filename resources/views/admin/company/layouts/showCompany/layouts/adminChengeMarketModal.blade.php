<div class="modal fade" id="change-market-modal" tabindex="-1" role="dialog" aria-labelledby="market-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title w-100 text-center" id="market-modal-title">Выбрать маркетплесы</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-8 offset-2">
                        <input type="hidden" name="company_id" form="group-product-actions" value="{{ $company->id }}">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <label class="switch mb-0">
                                    <input type="checkbox" class="" name="rozetka_on" form="group-product-actions" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                Rozetka
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                <label class="switch mb-0">
                                    <input type="checkbox" class="" name="prom_on" form="group-product-actions" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                Prom
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                <label class="switch mb-0">
                                    <input type="checkbox" class="" name="zakupka_on" form="group-product-actions" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                Zakupka
                            </div>
							
							{{-- временно в ручном режиме добавлено новый маркет --}}
                            <div class="col-4 d-flex align-items-center">
                                <label class="switch mb-0">
                                    <input type="checkbox" class="" name="fua_on" form="group-product-actions" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                F.ua
                            </div>
                            {{-- окончание блока временно в ручном режиме добавлено новый маркет --}}
                        </div>						
                    </div>
                </div>
                <button type="button" class="btn btn-success w-100 group-actions-p mb-2 mt-3" data-action="chmarket">применить</button>
                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">отмена</button>
            </div>
        </div>
    </div>
</div>