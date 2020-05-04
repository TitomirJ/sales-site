@extends('layouts.app')
@section('navbar')
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 order-2 order-md-1 p-0 ">
                @include('admin.blog.layouts.blog')
            </div>
            <div class="col-12 col-md-6 order-1 order-md-2 pt-5 pb-5 d-flex justify-content-center flex-column align-items-center bg-dark" style="height: 100vh;">

            </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection
