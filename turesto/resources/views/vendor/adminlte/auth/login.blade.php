@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Ingreso
@endsection

@section('mi-css')
<style type="text/css" media="screen">
    .img{
          background-image: url('{{url('/img/imagen1.jpeg')}}');
  background-size: cover;
  display: block;
  filter: blur(3px);
  -webkit-filter: blur(3px);
  height: 1000px;
  left: 0;
  position: fixed;
  right: 0;
  z-index: -1;
  margin: -120px;
    }
</style>
@endsection
@section('content')
<body class="hold-transition ">
    <div class="img"></div>
    <div id="app">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/home') }}"><b>Y</b>onley</a>
            </div><!-- /.login-logo -->
        <!-- revisa si hay errores en el formulario de login y los muestra -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-box-body">
        <p class="login-box-msg"> {{ trans('adminlte_lang::message.siginsession') }} </p>
        <form action="{{ url('/login') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <login-input-field
                    name="{{ config('auth.providers.users.field','email') }}"
                    domain="{{ config('auth.defaults.domain','') }}"
                    ></login-input-field>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                <span class="fa fa-key form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                </div><!-- /.col -->
            </div>
        </form>
        <br>
        <a href="{{ url('/password/reset') }}">Olvide Mi Contraseña!</a>
        <br><br>
        <!-- <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a> -->
        <a class="btn btn-info btn-flat" href="{{ URL('/') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> back</a>

    </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->
    </div>
    @include('adminlte::layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
