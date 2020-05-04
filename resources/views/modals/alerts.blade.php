@if(session('success'))
    <script>
        $( document ).ready(function(){
            $.toaster({ message : "{{session('success')}}", title : 'OK!', priority : 'success', settings : {'timeout' : 3000} });
        });
    </script>
@endif
@if(session('danger'))
    <script>
        $( document ).ready(function(){
            $.toaster({ message : "{{session('danger')}}", title : 'Sorry!', priority : 'danger', settings : {'timeout' : 3000} });
        });
    </script>
@endif
@if(session('warning'))
    <script>
        $( document ).ready(function(){
            $.toaster({ message : "{{session('warning')}}", title : 'Attention!', priority : 'warning', settings : {'timeout' : 3000} });
        });
    </script>
@endif
@if(session('info'))
    <script>
        $( document ).ready(function(){
            $.toaster({ message : "{{session('info')}}", title : 'Info:', priority : 'info', settings : {'timeout' : 3000} });
        });
    </script>
@endif
@if(session('errorsArray'))
    @foreach(session('errorsArray') as $keyError => $valueError)
        @foreach($valueError as $key => $value)
            <script>
                $( document ).ready(function(){
                    $.toaster({ message : "{{$value}}", title : '', priority : 'danger', settings : {'timeout' : 6000} });
                });
            </script>
        @endforeach
    @endforeach
@endif
@if(session('errors'))
    <script>
        @if ($errors->has('email'))
                $( document ).ready(function(){
                    $.toaster({ message : "{{$errors->first('email')}}", title : '', priority : 'danger', settings : {'timeout' : 6000} });
                });
        @endif
        @if ($errors->has('password'))
        $( document ).ready(function(){
            $.toaster({ message : "{{$errors->first('password')}}", title : '', priority : 'danger', settings : {'timeout' : 6000} });
        });
        @endif
    </script>
@endif