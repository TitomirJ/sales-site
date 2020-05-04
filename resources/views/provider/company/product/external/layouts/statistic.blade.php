<div class="table-responsive scroll_wrap">
    <table class="table position-relative scroll_me">
        <thead id="" class="table-bg">
        <tr class="font-weight-bold bor-bottom">
            <td scope="col" class="align-middle">
                <div class="d-block text-center text-uppercase text-nowrap">
                    Статус
                </div>
            </td>
            <td scope="col" class="align-middle">
                <div class="d-block text-center text-uppercase text-nowrap">
                    Ко-во записей
                </div>
            </td>
            <td scope="col" class="align-middle">
                <div class="d-block text-center text-uppercase text-nowrap">
                    Ко-во обработано
                </div>
            </td>
            <td scope="col" class="align-middle">
                <div class="d-block text-center text-uppercase text-nowrap">
                    Ко-во обновлено
                </div>
            </td>
            <td scope="col" class="align-middle">
                <div class="d-block text-center text-uppercase text-nowrap">
                    Ко-во ненайдено
                </div>
            </td>
            <td scope="col" class="align-middle">
                <div class="d-block text-center text-uppercase text-nowrap">
                    Создано
                </div>
            </td>
        </tr>
        </thead>

        <tbody>
        <tr class="bor-bottom">
            <td scope="col" class="text-center align-middle">
                <?
                    $status = $externalProduct->status;
                ?>
                @if($status == '0')
                    <span class="text-danger">Ожидает проверки</span>
                @elseif($status == '1')
                    <span class="text-warning">В работе</span>
                @elseif($status == '2')
                    <span class="text-success">Обновлено</span>
                @endif
            </td>

            <td scope="col" class="text-center align-middle">
                {{ $externalProduct->count_products }}
            </td>

            <td scope="col" class="text-center align-middle text-warning">
                {{ $externalProduct->step }}
            </td>

            <td scope="col" class="text-center align-middle text-success">
                {{ $externalProduct->count_updated }}
            </td>

            <td scope="col" class="text-center align-middle text-danger">
                {{ $externalProduct->count_notfound }}
            </td>

            <td scope="col" class="text-center align-middle">
                {{ $externalProduct->updated_at }}
            </td>
        </tr>
        </tbody>
    </table>
</div>