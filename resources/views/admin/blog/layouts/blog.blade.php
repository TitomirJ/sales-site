@isset($blog)
<div class="blog-1 container-fluid" style="overflow-y:hidden; background: url({{asset($blog->image_path)}}) center center no-repeat;
        background-size: cover;">
    <div class="row justify-content-center align-items-center">
        <div class="w-100 d-flex justify-content-center align-items-center h-75">
            <div class="blog-content p-2" style="overflow: auto; background: #00000054">
                {!! $blog->text !!}
            </div>
        </div>
    </div>
</div>
@endisset