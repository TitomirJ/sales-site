@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/switchBtn.css') }}">
@endsection

@section('content')
    <div class="content-wrapper bg-dark border rounded-left border-secondary">
        <div class="container-fluid">

            <h2 class="text-white">Отзывы</h2>

            <div class="table-responsive scroll_wrap">
                <table class="table table-dark table-hover text-center scroll_me">
                    <thead>
                    <tr>
                        <th scope="col">Фон</th>
                        <th scope="col">Название</th>
                        <th scope="col">Дата</th>
                        <th scope="col" class="text-center">Показывать</th>
                        <th scope="col">Действия</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th scope="col">Фон</th>
                        <th scope="col">Название</th>
                        <th scope="col">Дата</th>
                        <th scope="col" class="text-center">Показывать</th>
                        <th scope="col">Действия</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    @forelse($reviews as $r)
                        <tr>
                            <td scope="row">
                                <a href="{{asset($r->image_path)}}" target="_blank">
                                    <img src="{{ asset($r->image_path)}}" alt="" width="125">
                                </a>
                            </td>
                            <td class="align-middle">{{$r->label}}</td>
                            <td class="align-middle">{{$r->created_at}}</td>
                            <td class="text-center align-middle">
                                <form class="change-status-review" action="{{ asset('admin/review/'.$r->id.'/block') }}" method="POST">
                                    {{ csrf_field() }}
                                    <label class="switch mb-0">
                                        <input type="checkbox" class="" {{ ($r->block == '1') ? 'checked' : ''}} >
                                        <span class="slider round review-checkbox"></span>
                                    </label>
                                </form>
                            </td>
                            <td class="align-middle">
                                <a href="{{asset('/admin/review/'.$r->id.'/show')}}" class="d-inline-flex link text-primary btn-edit m-3" title="Просмотреть отзыв">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="{{asset('/admin/review/edit/'.$r->id)}}" class="d-inline-flex link text-warning btn-edit ml-5 mr-5 m-3" title="Редактировать отзыв">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="{{asset('/admin/review/'.$r->id).'/delete'}}" class="d-inline-flex link confirm-modal text-danger  btn-edit m-3" title="Удалить отзыв" text="Подтвердите удаление новости">
                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Нет отзывов</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>

            <form action="{{asset('/admin/review/create')}}" method="GET">
                <button type="submit"  class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Добавить отзыв
                </button>
            </form>



            <?$pagination_range=2;?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item {{ $reviews->previousPageUrl()==null ? 'disabled' : '' }}"><a class="page-link" href="{{$reviews->previousPageUrl()}}"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                    @if ($reviews->currentPage() > 1+$pagination_range )

                        <li class="page-item">
                            <a class="page-link on-overlay-loader" href="{{ $reviews->url(1)}}">{{ 1 }}</a>
                        </li>

                        @if ($reviews->currentPage() > 1+$pagination_range+1 )
                            <li class="page-item disabled">
                                <span class="page-link">&hellip;</span>
                            </li>
                        @endif

                    @endif

                    @for ($i=-$pagination_range; $i<=$pagination_range; $i++)

                        @if ($reviews->currentPage()+$i > 0 && $reviews->currentPage()+$i <= $reviews->lastPage())
                            <li class="page-item {{ $i==0 ? 'active' : '' }}">
                                <a class="page-link on-overlay-loader" href="{{ $reviews->url($reviews->currentPage()+$i) }}">{{ $reviews->currentPage()+$i }}</a>
                            </li>
                        @endif

                    @endfor

                    @if ($reviews->currentPage() < $reviews->lastPage()-$pagination_range )

                        @if ($reviews->currentPage() < $reviews->lastPage()-$pagination_range-1 )
                            <li class="page-item disabled">
                                <span class="page-link">&hellip;</span>
                            </li>
                        @endif

                        <li class="page-item">
                            <a class="page-link on-overlay-loader" href="{{ $reviews->url($reviews->lastPage())}}">{{ $reviews->lastPage() }}</a>
                        </li>

                    @endif

                    <li class="page-item {{ $reviews->nextPageUrl()==null ? 'disabled' : '' }}">
                        <a class="page-link on-overlay-loader" href="{{ $reviews->nextPageUrl()}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
@endsection
