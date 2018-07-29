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
	<a class="btn btn-primary " data-toggle="modal" href='#agregar-trabajador' title="Agregar Trabajador"><i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Trabajador</a>
@endsection

@section('contentheader_description')
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
	<div class="container-fluid spark-screen" >
		<div>
			<h1>Listado de trabajadores</h1>
		</div>
		<div class="row">
		@if ($errors->any())
			 
			<div class="alert alert-danger alert-dismissible" role="alert">
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Corriga los siguientes Campos: </h3>
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
		<!-- aqui se listaran todos los trabajadores de la empresa  -->
		 <table class="table table-responsive" id="listar-trabajadores" style="width: 100% !important;">
	        <thead>
	            <tr>
	                <th>Nombre</th>
	                <th>Paterno</th>
	                <th>Materno</th>
	                <th>rut</th>
	                <th>direccion</th>
	                <th>celular</th>
	                <th>fecha Nacimiento</th>
	                <th>perfil</th>
	                <th>Estado</th>
	                <th>Acciones</th>
	            </tr>
        	</thead>
	        <tfoot>
	            <tr>
	                <th>Nombre</th>
	                <th>Paterno</th>
	                <th>Materno</th>
	                <th>rut</th>
	                <th>direccion</th>
	                <th>celular</th>
	                <th>fecha Nacimiento</th>
	                <th>perfil</th>
	                <th>Estado</th>
	                <th>Acciones</th>
	            </tr>
	        </tfoot>
	    </table>
	</div>


<div class="modal fade " id="agregar-trabajador">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Nuevo Trabajador</h4>
			</div>

			<div class="modal-body">

				<form action="{{url('nuevotrabajador')}}" method="POST" role="form">

					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<label for="">Nombres</label>
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<input type="text" class="form-control " name="txtnombres" placeholder="Ej: alberto" required>
							</div>
						</div>
					</div>
<br>
					<div class="row">
						<div class="form-group">
							<div class="col-md-6">
								<label for="">Paterno</label>
								<input type="text" class="form-control" name="txtapellidopat" placeholder="Ej: perez">
							</div>
							<div class="col-md-6">
								<label for="">Materno</label>
								<input type="text" class="form-control" name="txtapellidomat" placeholder="Ej: sanches" required>
							</div>
						</div>
					</div>		
					<br>
					<div class="row">
						<div class="form-group">
							<div class="col-md-6">
								<label for="">Rut</label>
								<input type="text" class="form-control" name="txtrut" placeholder="Ej: 12345678-9" required>
							</div>
							<div class="col-md-6">
								<label for="">Sexo</label>
								<select name="txtsexo" id="txtsexo" class="form-control" required="required" required>
									<option value="#">seleccione..</option>
									<option value="0">Femenino</option>
									<option value="1">Masculino</option>
								</select>
							</div>
						</div>
					</div>
<br>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<label for="">Direccion</label>
								<input type="text" class="form-control" name="txtdireccion" placeholder="ej: av. argentina 7844" required>
							</div>
						</div> 
					</div>
<br>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<label for="">Region</label>
								<select name="txtregion" class="form-control" id="region" required>
									<option value="0">Seleccione...</option>
									@foreach ($regiones as $region)
										<option value="{{$region->region_id}}">{{$region->region_nombre}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
<br>
					<div class="row">
						<div class="form-group">
							<div class="col-md-6">
								<label for="">Provincia</label>
								<select name="txtprovincia" class="form-control" id="provincias" required>
									<option value="0">Seleccione...</option>
								</select>
							</div>
							<div class="col-md-6">
								<label for="">Comuna</label>
								<select name="txtcomuna" class="form-control" id="comunas" required>
									<option value="0">Seleccione...</option>
									
								</select>		
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-6">
							<label for="txtfecha">Fecha Nacimiento</label>
							<input type="date" class="form-control" name="txtfecha" placeholder="" required>
						</div>
						<div class="col-md-6">
							<label for="txtcelular">Celular</label>
							<input type="text" class="form-control" name="txtcelular" placeholder="" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label for="txtmail">Email</label>
							<input type="email" class="form-control" name="txtmail" placeholder="ejemplo@ej.cl" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label for="">Perfil</label>
								<select name="txtperfil" class="form-control" required>
									<option value="0">Seleccione...</option>
									@foreach ($perfiles as $perfil)
										<option value="{{$perfil->tp_id}}">{{$perfil->tp_descripcion}}</option>
									@endforeach
								</select>	
						</div>		
					</div>
					<br><br>
					<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-default " data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary pull-right">Registrar</button>
					</div>
					</div>
				</form>
			</div>
			
			<div class="modal-footer">
					
				
			</div>
			
		</div>
	</div>
</div>

@endsection



@section('mi-script')
<script type="text/javascript">

$(document).ready(function() {
	
	var tabla = $('#listar-trabajadores').DataTable({
	processing: true,
	dom: 'Bfrtip',
	buttons: [
	    'excel', 'pdf','print'
	],
	language: {
	      url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
	},
	"order": [[ 1, "asc" ]],
	ajax: '{{url ("trabajador/listar")}}',
	columns: [
	    { data: 'trabajador_nombres', name: 'nombres' },
	    { data: 'trabajador_ap', name: 'apellido_pat' },
	    { data: 'trabajador_am', name: 'apellido_mat' },
	    { data: 'trabajador_rut', name: 'rut' },
	    { data: 'trabajador_direccion', name: 'direccion' },
	    { data: 'trabajador_celular', name: 'ciudad' },
	    { data: 'trabajador_fecha_nace', name: 'fecha_nac' },
	    { data: 'tipoperfiles.tp_descripcion',  name: 'tp_descripcion' },
	    { data: 'trabajador_estado',  name: 'estado' }
	],
	"columnDefs": [ {
	    "targets": 9,
	    "data": "trabajador_id",
	    "render": function ( data, type, full, meta ) {
	      return '<a href="trabajador/editar/'+data+'" class="btn btn-warning" id="editar-trabajador" style="float:left; width:50%" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="trabajador/eliminar/'+data+'" class="btn btn-danger" id="eliminar-trabajador" style="float:left; width:50%" ><i class="fa fa-trash" aria-hidden="true"></i></a><br>';
	    }
	},
        {
            "targets": 8,
            "data": "sector_estado",
            "render": function ( data, type, row, meta ) {
              if (data == 1) return 'Activo'; else return 'Inactivo';
            }
        }
    ]
	});
	//desactivamos el select de provincias y comunas
	$('#provincias').prop('disabled', true);
	$('#comunas').prop('disabled', true);

	//al seleccionar una opcion del select region se desplegara este script
	//
	//
	

				
	$('#region').change( function (){
		var region = $(this).val();
		$('#provincias').prop('disabled', true);
		$('#comunas').prop('disabled', true);
		//console.log(region);
		$.ajax({
			type: 'GET',
			dataType: 'json',
			data: {'region':region    },
			url: '{{url ("trabajador/obtenerprovincias")}}'
		})
		.done(function(data) {
			$('#provincias option').remove();
			$('#comunas option').remove();
			$('#provincias').append('<option value="0">Seleccione...</option>');
			//volvemos a activar el select provincias una vez hemos obtenido los datos
			$('#provincias').prop('disabled',false);
			//console.log("success");
			//console.log(data);
			$.each(data, function(provincia_id,value){
				$("#provincias").append('<option value="'+value.provincia_id+'">'+value.provincia_nombre+'</option>');
	   				
	   			});
		})
		.fail(function(msg) {
			console.log("error");
		})
		.always(function(msg) {
			console.log("complete");
		});
		
	});

	$('#provincias').change( function (){
			$('#comunas').prop('disabled',true);
			var provincia = $(this).val();
					$.ajax({
						type: 'GET',
						dataType: 'json',
						data: {'provincia':provincia    },
						url: '{{url ("trabajador/obtenercomunas")}}'
					})
					.done(function(data) {
						$('#comunas option').remove();
						$('#comunas').append('<option value="0">Seleccione...</option>');
						//volvemos a activar el select provincias una vez hemos obtenido los datos
						$('#comunas').prop('disabled',false);
						//console.log("success");
						//console.log(data);
						$.each(data, function(provincia_id,value){
							$("#comunas").append('<option value="'+value.comuna_id+'">'+value.comuna_nombre+'</option>');
				   			

				   			});
					})
					.fail(function(msg) {
						console.log("error");
					})
					.always(function(msg) {
						console.log("complete");
					});

		});
	
});
</script>
@endsection