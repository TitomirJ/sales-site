
    <?
        $indicator = false;
        $users = $c->users;
        foreach ($users as $user){
            if($user->isOnline()){
                $indicator = true;
            }
        }
    ?>
    <div class="dropdown">
        <button class="btn-trans dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if($indicator)
                <i class="fa fa-eercast fa-2x text-success" aria-hidden="true"></i>
            @else
                <i class="fa fa-eercast fa-2x text-danger" aria-hidden="true"></i>
            @endif
        </button>
        @if(Auth::user()->isAdmin())
            <div class="dropdown-menu border-radius border-0 shadow-custom">
            <a  class="dropdown-item font-weight-bold drop-menu-actions">Сотрудники "{{ $c->name }}":</a>
            @foreach ($c->users as $user)
            @foreach($user->company->users as $item)
                @if($item->isOnline())
                    <a  class="dropdown-item drop-menu-actions"><i class="fa fa-user-circle-o text-success" aria-hidden="true"></i> {{ $item->getFullName() }}  {{ $item->email }}  <span class="text-success">(on-line) c {{ $item->lastTimeOnline() }}</span></a>
                @else
                    <a  class="dropdown-item drop-menu-actions"><i class="fa fa-user-circle-o text-danger" aria-hidden="true"></i> {{ $item->getFullName() }}  {{ $item->email }}  <span class="text-danger">(off-line) c {{ $item->lastTimeOnline() }}</span></a>
                @endif
                @endforeach
                @break
            @endforeach
        </div>
        @endif
    </div>

