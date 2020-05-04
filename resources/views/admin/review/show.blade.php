@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
                <pre>
            {{ print_r($review) }}
            </pre>
        </div>
    </div>
@endsection