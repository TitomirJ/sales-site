@extends('pdf.layouts.app')

@section('content')
    @foreach($transactions as $t)
        {{ $t->total_sum }}<br>
    @endforeach

@endsection