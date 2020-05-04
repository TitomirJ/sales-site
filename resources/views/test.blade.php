@foreach($users as $user)
    {{$user->id.' '.$user->email.' '.$user->roles[0]['name']}}<br>
@endforeach
<pre>
    {{ print_r($users) }}
</pre>