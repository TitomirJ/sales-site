@forelse($providers as $user)
    <tr class="text-center bor-bottom user-id-{{ $user->id }}">
        <td class="font-weight-bold">
            @if($user->isOnline())
                <i class="fa fa-eercast fa-2x text-success" aria-hidden="true"></i>
            @else
                <i class="fa fa-eercast fa-2x text-danger" aria-hidden="true"></i>
            @endif
        </td>
        <td class="font-weight-bold">
            <a href="{{asset('/admin/company/'.$user -> company -> id)}}">{{$user -> company -> name}}</a>
        </td>
        <td class="font-weight-bold">
            @if($user->name != "" && $user->surname != "")
                {{$user -> name }} {{$user -> surname }}
            @else
                Данные отсутсвуют
            @endif
        </td>
        <td class="font-weight-bold position-relative">
            <div class="message-copy position-absolute border-radius bg-dark p-1 text-white w-100 f12" style="display: none;">Нажмите для копирования<br> в буфер обмена</div>
            <a class="copy-buffer">{{$user->email}}</a>
        </td>
        <td class="font-weight-bold position-relative">
            <div class="message-copy position-absolute border-radius bg-dark p-1 text-white w-100 f12" style="display: none;">Нажмите для копирования<br> в буфер обмена</div>
            <a class="copy-buffer">{{$user->phone}}</a>
        </td>
        <td class="font-weight-bold">
        {{$user->products->count()}}
        </td>
        <td class="font-weight-bold">
            <a href="tel:{{$user->phone}}" title="Позвонить">
                <i class="fa fa-phone text-success" aria-hidden="true"></i>
            </a>
            <a href="" title="Написать" class="ml-3 mr-3">
                <i class="fa fa-envelope-o text-warning" aria-hidden="true"></i>
            </a>
            <a href="" title="Удалить">
                <i class="fa fa-times text-danger" aria-hidden="true"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center" >Записи отсутствуют</td>
    </tr>
@endforelse
<tr>
    <td colspan="7" class="pagination-wrapper" data-type="provider">{{ $providers->links() }}</td>
</tr>