<?

if(isset($blogs)){
    $count_blogs =  $blogs->count();
    $rand_blog = rand(0, ($count_blogs-1));
}
?>
@if(isset($blogs))
<div class="blog-1 container-fluid" style="overflow-y:hidden; background: url({{asset($blogs[$rand_blog]['image_path'])}}) center center no-repeat;
    background-size: cover;">

        <div class="row justify-content-center align-items-center">
            <div class="w-100 d-flex justify-content-center align-items-center h-75">
                @if($blogs[$rand_blog]['text'] != null)
                <div class="blog-content p-2" style="overflow: auto; background: #00000054">
                    {!! $blogs[$rand_blog]['text'] !!}
                </div>
                @endif
            </div>
        </div>

</div>
@endif