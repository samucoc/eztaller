<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadotrabajadores') }}
@endsection

@section('contentheader_title')
	
@endsection

@section('contentheader_description')
	<a class="btn btn-info" href="{{ URL('/trabajadores') }}"><i class="fa fa-angle-left" aria-hidden="true"></i> back</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
<div class="container-fluid spark-screen" >
	
@foreach($trabajadores as $trabajador)
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
	<div class="row">
		<div class="col-md-2 col-xs-3">
			<img src="{{url('/img/avatar.png')}}" alt="" class="img-responsive " width="150">
		</div>
		<div class="col-md-10 col-xs-9">
			<h2><i class="fa fa-user" aria-hidden="true"></i>{{$trabajador->trabajador_nombres}}<small>{{$trabajador->trabajador_ap}}  {{$trabajador->trabajador_am}}</small> </h2>
			<h3>
			<span class="label label-success"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> {{$trabajador->trabajador_fecha_nace}}</span>
			<span class="label label-info"><i class="fa fa-address-card" aria-hidden="true"></i> {{$trabajador->trabajador_rut}}</span>
			</h3>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<form action="{{url('trabajador/guardar')}}" method="" role="form">
				<div class="form-group">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<input type="hidden" name="txtid" value="{{$trabajador->trabajador_id}}" />

					<label for="txtdireccion"><i class="fa fa-map-marker" aria-hidden="true"></i> Direccion</label>
					<input type="text" class="form-control" name="txtdireccion" placeholder="" value="{{$trabajador->trabajador_direccion}}">
				</div>
				<div class="form-group">
					<label for="txtcelular"><i class="fa fa-mobile" aria-hidden="true" ></i> Celular</label>
					<input type="text" class="form-control" maxlength="9" name="txtcelular" placeholder="" value="{{$trabajador->trabajador_celular}}">
				</div>
				<div class="form-group">
					<label for="txtperfil"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Perfil</label>
					<select class="form-control" name="txtperfil">
						<option value="0">Seleccione...</option>
						@foreach ($perfiles as $perfil)
						  <option value="{{$perfil->tp_id}}" @if($trabajador->tp_id == $perfil->tp_id)  selected="selected" @endif>{{$perfil->tp_descripcion}}</option>
						@endforeach
					</select>
					
				</div>
				<div class="form-group">
						@if($trabajador->trabajador_estado == 1) 
							<input type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" name="txtestado">
						@else 
							<input type="checkbox" data-toggle="toggle"  data-on="Activo" data-off="Inactivo" name="txtestado">
						@endif 
				</div>
				<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
			</form>
		</div>
	</div>
	<br><br><br>
	<div class="row">
		<div class="alert alert-warning" role="alert">
			<h2>Importante!!! </h2>
			<p>solo podras editar ciertos campos de cada trabajador.</p>
		</div>
	</div>	

@endforeach






</div>
@endsection



