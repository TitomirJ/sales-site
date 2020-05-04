<?php
    if(isset($info_updates) && $info_updates != NULL){

        $info = json_decode($info_updates->info_update);
    //dd($info);
    }else{
        $info_updates = false;
    }
	
	$btn_backup_work = \App\Http\Controllers\Prom\ProviderBackupController::isWorkedBackup();

?>
@if($info_updates)
@if($info !== NULL)
<h4>Отчет по автообновлению</h4>
@if($info_updates->error_update == NULL)
    @if($info[0]->new_product == 0 && $info[0]->update_product == 0)

        <p>Данные в файле не изменялись с {{$info_updates->date_update}}</p>

    @else

    <table class="table">
        <thead align="center">
            <tr>
            <td>Дата обновления</td>
            <td>Кол-во новых продуктов</td>
            <td>Кол-во обновленных продуктов</td>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
            <td>{{$info_updates->date_update}}</td>
            <td>{{$info[0]->new_product}}</td>
            <td>{{$info[0]->update_product}}</td>
            </tr>
        </tbody>
    </table>
    @endif
    @else
    <div class="alert alert-danger" role="alert">
        При обновлении данных возникли ошибки, обратитесь к менеджеру
      </div>
    @endif
@else
<div class="alert alert-warning" role="alert">
    По этой ссылке еще нет данных для отображения
  </div>
@endif

{{-- кнопка для бэкапа автообновления (апрель 2020) --}}
@if(Auth::user()->company_id ==59 && $btn_backup_work)
<div class="wrap_audbackup bg-light p-2">
    <p>Вы можете возвратить информацию о товарах до автообновления</p>
    <span class="badge badge-info" id="title_backup" style="cursor:pointer;">Показать кнопку</span>

    <div class="block_form_backup text-center" id="bbackup" style="display:none;">
        <span class="font-italic">Внимание!При использовании бэкапа вся информация из автообновления, о товарах находящихся в личном кабинете, будет удалена!</span>
        <form action="{{route('audbackup')}}" method="POST">
            {{ csrf_field() }}
        <input type="hidden" name="comp" value="{{Auth::user()->company_id}}">
            <button class="btn btn-danger">Backup</button>
        </form>
    </div>

</div>
@endif

@endif