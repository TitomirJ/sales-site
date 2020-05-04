@if(session('success'))
    <script>
        $( document ).ready(function(){
            $('.success').fadeIn();

            setTimeout(function() {
                $('.success').fadeOut();
            }, 5000);
        });
    </script>
@endif
@if(session('danger'))
    <script>
        $( document ).ready(function(){
            $('.danger').fadeIn();

            setTimeout(function() {
                $('.danger').fadeOut();
            }, 5000);
        });
    </script>
@endif
@if(session('warning'))
    <script>
        $( document ).ready(function(){
            $('.warning').fadeIn();

            setTimeout(function() {
                $('.warning').fadeOut();
            }, 5000);
        });
    </script>
@endif
@if(session('info'))
    <script>
        $( document ).ready(function(){
            $('.info').fadeIn();

            setTimeout(function() {
                $('.info').fadeOut();
            }, 5000);
        });
    </script>
@endif