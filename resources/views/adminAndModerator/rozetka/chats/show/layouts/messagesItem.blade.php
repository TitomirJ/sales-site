@forelse($chart->messages as  $msg)

    @if($msg->sender == '0')
        <div class="message message--market">
            <time class="message__time">{{ $msg->created_at }}</time>
            <figure class="message__author-pic message__icon--market">
                <img src="{{ asset('images/support.png') }}">
            </figure>
            <div class="message__text message__text--market" style="min-width: 50%; max-width: 85%;">
                <div class="message__text--user message__user--market">
                    <p class="mr-3">Rozetka.com.ua</p>
                </div>
                <p>{!! $msg->body !!}</p>
            </div>
        </div>
    @elseif($msg->sender == '2')
        <div class="message message--provider">
            <time class="message__time">{{ $msg->created_at }}</time>
            <figure class="message__author-pic message__icon--provider">
                <img src="{{ asset('images/cam.png') }}">
            </figure>
            <div class="message__text message__text--provider" style="min-width: 50%; max-width: 85%;">
                <div class="message__text--user message__user--provider">
                    <p class="ml-3">{{ \Auth::user()->name.' '.\Auth::user()->surname }}</p>
                </div>
                <p class="text-right">{{ $msg->body }}</p>
            </div>
        </div>
    @elseif($msg->sender == '3')
        <div class="message message--customer">
            <time class="message__time">{{ $msg->created_at }}</time>
            <figure class="message__author-pic message__icon--customer">
                <img src="{{ asset('images/mental.png') }}">
            </figure>
            <div class="message__text message__text--customer" style="min-width: 50%; max-width: 85%;">
                <div class="message__text--user message__user--customer">
                    <p class="mr-3">{{ $chart->receiver->contact_fio }}</p>
                </div>
                <p>{{ $msg->body }}</p>
            </div>
        </div>
    @endif
@empty
@endforelse