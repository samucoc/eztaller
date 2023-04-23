<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@php 	$ruta = "menuhijos"; $modal = "menuhijo";	 	 @endphp
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadomenuhijos') }}
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-primary " data-toggle="modal" href='#agregar-{{$modal}}' title="Agregar Sub menu"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Sub Menu</a>

@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
	<div class="container-fluid spark-screen" >
	<h2>Listado de <small> Sub-Menues</small></h2>
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
		<div class="table-responsive">
			<table class="table table-hover" id="listar-{{$ruta}}">
				<thead>
					<tr>
						<th>Descripcion</th>
						<th>Link</th>
						<th>Menu</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Descripcion</th>
						<th>Link</th>
						<th>Menu</th>
						<th>Acciones</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

<div class="modal fade " id="agregar-{{$modal}}">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Nuevo Sub-Menu</h4>
			</div>

			<div class="modal-body">
				<div class="row">
						<form action="{{url('mantenedores/menuhijos/crear')}}" method="POST" role="form">
					<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
							</div>
							<div class="form-group">
								<label for="txtdescripcion"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Nombre Submenu</label>
								<input type="text" class="form-control" name="txtdescripcion" placeholder="" value="" >
							</div>
							<div class="form-group">
								<label for="txtlink"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Link</label>
								<input type="text" class="form-control" name="txtlink" placeholder="" value="">
							</div>
							<div class="form-group">
								<label for="txtmenu"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Menu</label>
								<select class="form-control" name="txtmenu">
									<option value="0">Seleccione..</option>
									@foreach($menues as $menu)
										<option value="{{$menu->menu_id}}">{{$menu->menu_descripcion}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label class="radio-inline">
  									<input type="radio" name="opcion" id="submenu" value="1" checked> Seleccione si tendra Sub-menu.
								</label>
								<label class="radio-inline">
  									<input type="radio"  name="opcion" id="subhijo" value="2"> Seleccione si es Sub-menu hijo.
								</label>
								<label class="radio-inline">
  									<input type="radio"  name="opcion" id="#" value="3"> Seleccione si es solo Sub-menu.
								</label>
							</div>
							<div class="form-group">
								<select class="form-control" disabled name="txtsubhijo" id="ssubhijo">
									<option value="0">Seleccione..</option>
									@foreach($subs as $sub)
										<option value="{{$sub->mhijo_id}}">{{$sub->mhijo_descripcion}}</option>
									@endforeach
								</select>
							</div>
							<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
					</div>
						
				</div>
				
			
			<div class="modal-footer">
					
				
			</div>
			</form>
		</div>
	</div>
</div>




@endsection

@section('mi-script')
<script type="text/javascript">

$(document).ready(function() {

	$('#subhijo').change(function() {
		$('#ssubhijo').prop("disabled", false);
	});
	$('#submenu').change(function() {
		$('#ssubhijo').prop("disabled", true);
	});


	var tabla = $('#listar-{{$ruta}}').DataTable({
        processing: true,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf','print'
        ],
        "order": [[ 2, "asc" ]],
        language: {
              url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
        },
        ajax: '{{url ("mantenedores/menuhijos/listar")}}',
        columns: [
        	{ data: 'mhijo_descripcion', name: 'descripcion' },
            { data: 'mhijo_link', name: 'link' },
            { data: 'menu_id', name: 'menu' }
        ],
        "columnDefs": [ {
            "targets": 3,
            "data": "mhijo_id",
            "render": function ( data, type, full, meta ) {
              return '<a href="{{$ruta}}/editar/'+data+'" class="btn btn-warning" id="editar-{{$ruta}}" style="float:left; width:50%" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="{{$ruta}}/eliminar/'+data+'" class="btn btn-danger" id="eliminar-{{$ruta}}" style="float:left; width:50%" ><i class="fa fa-trash" aria-hidden="true"></i></a><br>';
            }
        } ]
    });




	
});
</script>
@endsection
