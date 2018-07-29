<!DOCTYPE html>
{{--
    esta es la primera pagina que se muestra al ingresar al sitio.
    aqui es donde se podran logear los usuarios del sistema, seleccionando la opcion del menu login.

Landing page based on Pratt: http://blacktie.co/demo/pratt/
--}}
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Yonley - {{ trans('adminlte_lang::message.yonleydescripcion') }} ">
    <meta name="author" content="Elvis Muñoz - Yonley">

    <meta property="og:title" content="Yonley" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Yonley - {{ trans('adminlte_lang::message.yonleydescripcion') }}" />
    <meta property="og:url" content="http://demo.adminlte.acacha.org/" />
    <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE.png" />
    <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE600x600.png" />
    <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE600x314.png" />
    <meta property="og:sitename" content="demo.adminlte.acacha.org" />
    <meta property="og:url" content="http://demo.adminlte.acacha.org" />

    <title>Yonley - {{ trans('adminlte_lang::message.yonleydescripcion') }}</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{url('/plugins/aos.css')}}">
    <style type="text/css" media="screen">
    .portada{
        background: url("{{url('/img/portada.jpeg')}}") fixed; //Imagen de fondo
        max-height: 100%;
        height: 100%; //altura del fondo
        position: relative;
        margin: 0 auto;
        padding: 10%;
        background-size: cover; //ajusta el fondo a la imagen
    }
    .portada h1{
        font-weight:normal;
        letter-spacing:3pt;
        word-spacing:1pt;
        font-size:15vw;
        text-align:center;
        font-family:arial, helvetica, sans-serif;
        color: #fff;
    }
    .portada p{
        font-weight:normal;
        letter-spacing:3pt;
        word-spacing:1pt;
        font-size:2vw;
        text-align:center;
        font-family:arial, helvetica, sans-serif;
        line-height:2;
        text-transform: uppercase;
    }
    .acerca{
        padding: 40px;
        
    }
    .acerca h1{
        margin: 30px;
    }
    .comocomprar{
        background: url("{{url('/img/comocomprar.jpeg')}}") fixed; //Imagen de fondo
        max-height: 100%;
        height: 730px; //altura del fondo
        position: relative;
        margin: 0 auto;
        padding: 5%;
        background-size: cover; //ajusta el fondo a la imagen
    }
    .contacto{
        background: url("{{url('/img/contacto.jpg')}}") fixed; //Imagen de fondo
        max-height: 100%;
        height: 730px; //altura del fondo
        position: relative;
        margin: 0 auto;
        padding: 5%;
        background-size: cover; //ajusta el fondo a la imagen
    }
    .navbar-brand{
        font-size: 40px;
    }
    </style>
</head>

<body data-spy="scroll" data-target="#navigation" data-offset="50" id="img">

<div id="app">
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{url('/')}}"><b>Yonley</b></a>
            </div>
            <div class="navbar-collapse collapse">
               <!-- muestra los links para login y registrar -->
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                    @else
                        <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                        <li><a href="{{url('/home')}}">{{ Auth::user()->name }}</a></li>
                    @endif
                </ul>
                <!--
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#acerca" title="">Acerca de Nosotros</a></li>
                    <li><a href="#comocomprar" title="">Como Comprar</a></li>
                    <li><a href="#contacto" title="">Contactanos</a></li>

                </ul>
                -->
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="portada text-center" id="portadaa">
    <h1>Yonley</h1>
    <p>Comercializadora e Importadora </p>
</div>
<!--
<div class="acerca aos-item" data-aos="fade-up" data-aos-duration="800" id="acerca">
    <div class="container">
        <div class="col-md-12">
            <h1 class="text-center aos-item__inner">Acerca de Nosotros</h1>
            <hr class="center-block" width="40%">
            <p class="text-justify aos-item__inner">
                <i class="fa fa-quote-left fa-3x fa-pull-left fa-border" aria-hidden="true"></i>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>   
        </div>
        <div class="col-md-12 aos-item" data-aos="zoom-in" data-aos-duration="800">
            <img src="{{url('/img/user8-128x128.jpg')}}" alt="" class="img-circle center-block aos-item__inner">
        </div>
    </div>
</div>

<div class="comocomprar" id="comocomprar">
    <h1>hola mundo</h1>
</div>
<div class="contacto" id="contacto">
    <h1 class="text-center">Comunicate con nosotros</h1>
    <form action="#" method="POST" role="form">
    
        <div class="form-group">
            <label for="">Nombre</label>
            <input type="text" class="form-control" id="" placeholder="Input field">
        </div>
        <div class="form-group">
            <label for="">Telefono</label>
            <input type="text" class="form-control" id="" placeholder="Input field">
        </div>
        <div class="form-group">
            <label for="">Mail</label>
            <input type="text" class="form-control" id="" placeholder="Input field">
        </div>
        <div class="form-group">
            <label for="">Mensaje</label>
            <textarea name=""></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-flat">Submit</button>
    </form>
</div>
<footer class="footer">
<div class="container">
    <div class="col-md-4">
        <h2>Contacto</h2>
        <address>
          <strong>Yonley, Inc.</strong><br>
          1355 Market Street, Suite 900<br>
          San Francisco, CA 94103<br>
          <abbr title="Phone">P:</abbr> (123) 456-7890
        </address>

        <address>
          <strong>Yonley Comercializadora</strong><br>
          <a href="mailto:#">yonley@yonley.com</a>
        </address>
    </div>
    <div class="col-md-4">
        <h2>Links</h2>
        <p>Como comprar</p>
        <p>Acerca de nosotros</p>
        <p>contactanos</p>
    </div>
    <div class="col-md-4">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
</div>
</footer>
-->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ url('/js/app-landing.js') }}"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="{{url('/plugins/aos.js')}}" ></script>
<script>
    $(window).scroll(function(){
        var barra = $(window).scrollTop();
        var posicion = barra * 0.04;
 
        $('body').css({
            'background-position': '0 ' + posicion + 'px'
        });
    });

    AOS.init();
</script>
</body>
</html>
