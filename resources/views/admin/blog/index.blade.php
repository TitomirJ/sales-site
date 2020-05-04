@extends('admin.layouts.app')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/modules/switchBtn.css') }}">
@endsection

@section('content')
    <div class="content-wrapper bg-dark border rounded-left border-secondary">
        <div class="container-fluid">

            @include('admin.layouts.breadcrumbs')

            <h2 class="text-white">Новости</h2>

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

                    @forelse($blogs as $b)
                        <tr>
                            <td scope="row">
                                <a href="{{asset($b->image_path)}}" target="_blank">
                                    <img src="{{ asset($b->image_path)}}" alt="" width="125">
                                </a>
                            </td>
                            <td class="align-middle">{{$b->label}}</td>
                            <td class="align-middle">{{$b->created_at}}</td>
                            <td class="text-center align-middle">
                                <form class="change-status-blog" action="{{ asset('admin/blog/'.$b->id.'/block') }}" method="POST">
                                    {{ csrf_field() }}
                                    <label class="switch mb-0">
                                        <input type="checkbox" class="" {{ ($b->block == '1') ? 'checked' : ''}} >
                                        <span class="slider round blog-checkbox"></span>
                                    </label>
                                </form>
                            </td>
                            <td class="align-middle">
                                <a href="{{asset('/admin/blog/'.$b->id.'/show')}}" class="d-inline-flex link text-primary btn-edit m-3" title="Просмотреть новость">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="{{asset('/admin/blog/edit/'.$b->id)}}" class="d-inline-flex link text-warning btn-edit ml-5 mr-5 m-3" title="Редактировать новость">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="{{asset('/admin/blog/'.$b->id).'/delete'}}" class="d-inline-flex link confirm-modal text-danger  btn-edit m-3" title="Удалить новость" text="Подтвердите удаление новости">
                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Нет новостей</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>

            <form action="{{asset('/admin/blog/create')}}" method="GET">
                <button type="submit"  class="btn square_btn shadow-custom text-uppercase border-radius-50 btn-lg w-100 mt-2 mb-3">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Добавить новость
                </button>
            </form>



            <?$pagination_range=2;?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item {{ $blogs->previousPageUrl()==null ? 'disabled' : '' }}"><a class="page-link" href="{{$blogs->previousPageUrl()}}"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                    @if ($blogs->currentPage() > 1+$pagination_range )

                        <li class="page-item">
                            <a class="page-link on-overlay-loader" href="{{ $blogs->url(1)}}">{{ 1 }}</a>
                        </li>

                        @if ($blogs->currentPage() > 1+$pagination_range+1 )
                            <li class="page-item disabled">
                                <span class="page-link">&hellip;</span>
                            </li>
                        @endif

                    @endif

                    @for ($i=-$pagination_range; $i<=$pagination_range; $i++)

                        @if ($blogs->currentPage()+$i > 0 && $blogs->currentPage()+$i <= $blogs->lastPage())
                            <li class="page-item {{ $i==0 ? 'active' : '' }}">
                                <a class="page-link on-overlay-loader" href="{{ $blogs->url($blogs->currentPage()+$i) }}">{{ $blogs->currentPage()+$i }}</a>
                            </li>
                        @endif

                    @endfor

                    @if ($blogs->currentPage() < $blogs->lastPage()-$pagination_range )

                        @if ($blogs->currentPage() < $blogs->lastPage()-$pagination_range-1 )
                            <li class="page-item disabled">
                                <span class="page-link">&hellip;</span>
                            </li>
                        @endif

                        <li class="page-item">
                            <a class="page-link on-overlay-loader" href="{{ $blogs->url($blogs->lastPage())}}">{{ $blogs->lastPage() }}</a>
                        </li>

                    @endif

                    <li class="page-item {{ $blogs->nextPageUrl()==null ? 'disabled' : '' }}">
                        <a class="page-link on-overlay-loader" href="{{ $blogs->nextPageUrl()}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
@endsection
