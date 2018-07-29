{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

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
<a class="btn btn-info" href="{{ URL('/mantenedores/sectores') }}"><i class="fa fa-angle-left" aria-hidden="true"></i> back</a>
@endsection

{{-- aqui escribiremos todo el codigo para cada pagina, la cual se mostrara en el @yield('main-content') de la pagina app.blade.php
--}}

@section('main-content')
<div class="container">
	@foreach ($sectores as $sector)
		<div class="col-md-10 col-xs-9">
			<h2><i class="fa fa-industry" aria-hidden="true"></i> datos del Sector</h2>
		</div>
		
		<br>
		<div class="row">
			<div class="col-md-12">
				<form action="{{url('mantenedores/sectores/guardar')}}" method="" role="form">
					<div class="form-group">
						<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
						<input type="hidden" name="txtid" value="{{$sector->sector_id}}" />
					</div>
					<div class="form-group">
						<label for="txtcodigo"><i class="fa fa-id-card-o" aria-hidden="true"></i> codigo</label>
						<input type="text" class="form-control" name="txtcodigo" placeholder="{{$sector->sector_codigo}}" value="{{$sector->sector_codigo}}">
					</div>
					<div class="form-group">
						<label for="txtdescripcion"><i class="fa fa-id-card-o" aria-hidden="true"></i> descripcion</label>
						<input type="text" class="form-control" name="txtdescripcion" placeholder="{{$sector->sector_descripcion}}" value="{{$sector->sector_descripcion}}">
					</div>
					<div class="form-group">
						<label for="txtestado"><i class="fa fa-id-card-o" aria-hidden="true"></i> Estado</label>
						<input type="text" class="form-control" name="txtestado" placeholder="{{$sector->sector_estado}}" value="{{$sector->sector_estado}}">
					</div>
					<div class="form-group">
						<label for="txtzona"><i class="fa fa-id-card-o" aria-hidden="true"></i> Zona</label>
						<select class="form-control" name="txtzona">
							@foreach ($zonas as $zona)
							  <option value="{{$zona->zona_id}}" >{{$zona->zona_descripcion}}</option>
							@endforeach
						</select>
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
