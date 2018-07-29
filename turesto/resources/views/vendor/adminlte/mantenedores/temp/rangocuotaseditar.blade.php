<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->
@php 	$ruta = "rangocuotas"; $rutasingular = "rangocuotas";@endphp
<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	
@endsection

@section('contentheader_title')

@endsection
	<div class="row">
		@if ($errors->any())
			<div class="alert alert-danger alert-dismissible" role="alert">
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p>Corriga lo siguiente: </p>
			<ul>
				@foreach($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</ul>
			</div>
		@endif

		@if (Session::get('notice') !='')
		<div class="alert alert-info" role="alert"><p> <strong> {{ Session::get('notice') }} </strong> </p></div>
		@endif
	</div>
@section('contentheader_description')
<a class="btn btn-info" href="{{ URL('/mantenedores/rangocuotas') }}"><i class="fa fa-angle-left" aria-hidden="true"></i> back</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')

<div class="container">
	@foreach ($rangocuotas as $rangocuota)
		<div class="col-md-10 col-xs-9">
			<h2><i class="fa fa-industry" aria-hidden="true"></i> Rango Descuento</h2>
		</div>
		
		<br>
		<div class="row">
			<div class="col-md-12">
				<form action="{{url('mantenedores/rangocuotas/guardar')}}" method="" role="form">
					<div class="form-group">
						<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
						<input type="hidden" name="txtid" value="{{$rangocuota->rcc_id}}" />
					</div>
					
					<div class="form-group">
						<label for="txtinicio"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Inicio</label>
						<input type="text" class="form-control" name="txtinicio" placeholder="" value="{{$rangocuota->rcc_inicio}}" r>
					</div>
					<div class="form-group">
						<label for="txtfin"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Fin</label>
						<input type="text" class="form-control" name="txtfin" placeholder="" value="{{$rangocuota->rcc_fin}}" r>
					</div>
					<div class="form-group">
						<label for="txtdias"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Dias</label>
						<input type="text" class="form-control" name="txtdias" placeholder="" value="{{$rangocuota->rcc_dias}}" r>
					</div>
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
				</form>
			</div>
		</div>
	@endforeach
	<br><br><br>
	<div class="row">
		<div class="alert alert-warning" role="alert">
			<h2>Importante!!! </h2>
			<p>solo podras editar ciertos campos de cada banco.</p>
		</div>
	</div>
</div>
@endsection
