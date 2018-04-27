@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{{$churchname}}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            @include('bookclub::shared.loginform')
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    <script src="{{ asset('/vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        @include('bookclub::shared.login-modal-script')
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
