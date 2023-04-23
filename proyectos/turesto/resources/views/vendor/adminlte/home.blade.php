{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
	{{trans('adminlte_lang::message.home')}}
@endsection

@section('mi-css')
<style type="text/css" media="screen">

.cant_ventas h1{
font-weight:normal;
letter-spacing:3pt;
word-spacing:1pt;
font-size:15vw;
text-align:center;
font-family:arial, helvetica, sans-serif;
color: #39CCCC;
}

.cant_ventas p{
font-weight:normal;
letter-spacing:3pt;
word-spacing:1pt;
font-size:40px;
text-align:center;
font-family:arial, helvetica, sans-serif;
line-height:2;
text-transform: uppercase;
}

.boxi{
	width: 100%;
	min-height: 150px;
}
.box-info{
	min-height: 150px;
	width: 100%;
	background: white;
	-webkit-box-shadow: 2px 3px 10px -1px rgba(122,121,122,0.59);
	-moz-box-shadow: 2px 3px 10px -1px rgba(122,121,122,0.59);
	box-shadow: 2px 3px 10px -1px rgba(122,121,122,0.59);
	-webkit-transition: width 2s; /* Safari */
    transition: width 2s;
	padding: 5px;
	color: #39CCCC;
}
.box-info h1{
	color: #39CCCC;
	letter-spacing: 3pt;
}
.box-info p{
	color: #d2d6de;
	letter-spacing: 2pt;
	text-transform: uppercase;
}
.box-info i{
	min-height: 70px;
	color: #39CCCC;
	display: block;
	text-align: center;
	font-size: 50px;
	line-height: 70px;
	margin-top: 30px;
}
.box-info:hover{
	background: #3c8dbc;
	color: white;
}
</style>
@endsection

@section('contentheader_description')
	
@endsection

{{-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php --}}

@section('main-content')
<div class="container-fluid spark-screen">
	<div class="row">
		<!--
		<div class="col-md-12 cant_ventas">
			<h1>1.010.985</h1>
			<p>total Ventas</p>
		</div>
		
		<div class="col-md-3 col-xs-12">
			<div class="boxi">
				<div class="box-info text-center "> 
	                <i class="fa fa-usd fa-4x" ></i>
	            	<hr width="80%"> 
					<h1 class="">253.654</h1>
	            	<p class="">Ventas de la semana</p>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12">
			<div class="boxi">
				<div class="box-info text-center "> 
	                <i class="fa fa-shopping-cart fa-4x" ></i>
	            	<hr width="80%"> 
					<h1 class="">253.654</h1>
	            	<p class="">Ventas</p>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12">
			<div class="boxi">
				<div class="box-info text-center "> 
	                <i class="fa fa-users fa-4x"></i>
	            	<hr width="80%"> 
					<h1 class="">253.654</h1>
	            	<p class="">clientes activos</p>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12">
			<div class="boxi">
				<div class="box-info text-center "> 
	                <i class="fa fa-user fa-4x"></i>
	            	<hr width="80%"> 
					<h1 class="">253</h1>
	            	<p class="">Trabajadores Activos</p>
				</div>
			</div>
		</div>
		-->
	</div>
	<br><br><br>
</div>
@endsection
