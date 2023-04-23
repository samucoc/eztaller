<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

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
<a class="btn btn-info" href="{{ URL('/mantenedores/ips') }}"><i class="fa fa-angle-left" aria-hidden="true"></i> back</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
<div class="container">
@foreach ($ips as $banco)
		<div class="col-md-10 col-xs-9">
			<h2><i class="fa fa-industry" aria-hidden="true"></i> Ips</h2>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<form action="{{url('mantenedores/ips/guardar')}}" method="" role="form">
				<div class="form-group">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<input type="hidden" name="txtid" value="{{$banco->ips_ncorr}}" />

					<label for="txtdescripcion"><i class="fa fa-id-card-o" aria-hidden="true"></i> Nombre</label>
					<input type="text" class="form-control" name="txtdescripcion" placeholder="{{$banco->nombre}}" value="{{$banco->nombre}}">
				</div>
				<div class="form-group">
					<label for="txtporc_cot"><i class="fa fa-id-card-o" aria-hidden="true"></i> Porcentaje</label>
					<input type="text" class="form-control" name="txtporc_cot" placeholder="{{$banco->porc_cot}}" value="{{$banco->porc_cot}}">
				</div>
				<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
			</form>
		</div>
	</div>
@endforeach
	<br><br><br>
	
</div>
@endsection

