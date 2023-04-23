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
	
@section('contentheader_description')
<a class="btn btn-info" href="{{ URL('/mantenedores/empresas') }}"><i class="fa fa-angle-left" aria-hidden="true"></i> back</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
<div class="container">
@foreach ($empresas as $empresa)
	<div class="row">
		<div class="row">
			<div class="col-md-10 col-xs-9">
				<h2><i class="fa fa-industry" aria-hidden="true"></i>  Rut Empresa: <small>{{$empresa->empresa_rut}}</small></h2>
			</div>
		</div>
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
	</div>
	<br>
	<div class="row">
		<form action="{{url('mantenedores/empresas/guardar')}}" method="" role="form">
		<div class="col-md-12">
				<div class="form-group">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<input type="hidden" name="txtid" value="{{$empresa->empresa_id}}" />

					<label for="txtnombre"><i class="fa fa-id-card-o" aria-hidden="true"></i> Nombre</label>
					<input type="text" class="form-control" name="txtnombre" placeholder="{{$empresa->empresa_nombre}}" value="{{$empresa->empresa_nombre}}">
				</div>
				<div class="form-group">
					<label for="txtdireccion"><i class="fa fa-map-marker" aria-hidden="true"></i> Direccion</label>
					<input type="text" class="form-control" name="txtdireccion" placeholder="{{$empresa->empresa_direccion}}" value="{{$empresa->empresa_direccion}}">
				</div>
				<div class="form-group">
					<label for="txtgiro"><i class="fa fa-briefcase" aria-hidden="true"></i> Giro</label>
					<input type="text" class="form-control" maxlength="9" name="txtgiro" placeholder="{{$empresa->empresa_giro}}" value="{{$empresa->empresa_giro}}">
				</div>
				<div class="form-group">
					<label for="txtmutual"><i class="fa fa-ambulance" aria-hidden="true"></i> Mutual</label>
					<input type="text" class="form-control" maxlength="9" name="txtmutual" placeholder="{{$empresa->empresa_mutual}}" value="{{$empresa->empresa_mutual}}">
				</div>
				<div class="form-group">
						@if($empresa->empresa_estado == 1) 
							<input type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" name="txtestado">
						@else 
							<input type="checkbox" data-toggle="toggle"  data-on="Activo" data-off="Inactivo" name="txtestado">
						@endif 
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
			<p>solo podras editar ciertos campos de cada empresa.</p>
		</div>
	</div>
</div>
@endsection

