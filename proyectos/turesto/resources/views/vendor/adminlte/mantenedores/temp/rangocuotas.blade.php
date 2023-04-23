<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@php 	$ruta = "rangocuotas"; $modal = "rangocuota";	 	 @endphp
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadorangocuotas') }}
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-primary " data-toggle="modal" href='#agregar-{{$modal}}' title="Agregar Rango cuota"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Rango cuota</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
	<div class="container-fluid spark-screen" >
	<h2>Listado de <small> Rangos de cuotas</small></h2>
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
						<th>ID</th>
						<th>Inicio</th>
						<th>Fin</th>
						<th>Dias</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Inicio</th>
						<th>Fin</th>
						<th>Dias</th>
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
				<h4 class="modal-title">Nueva Rango de Descuento</h4>
			</div>

			<div class="modal-body">
				<div class="row">
						<form action="{{url('mantenedores/rangocuotas/crear')}}" method="POST" role="form">
					<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
							</div>
							<div class="form-group">
								<label for="txtinicio"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Inicio</label>
								<input type="text" class="form-control" name="txtinicio" placeholder="" value="" r>
							</div>
							<div class="form-group">
								<label for="txtfin"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Fin</label>
								<input type="text" class="form-control" name="txtfin" placeholder="" value="" r>
							</div>
							<div class="form-group">
								<label for="txtdias"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Dias</label>
								<input type="text" class="form-control" name="txtdias" placeholder="" value="" r>
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
	var tabla = $('#listar-{{$ruta}}').DataTable({
        processing: true,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf','print'
        ],
        "order": [[ 1, "asc" ]],
        language: {
              url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
        },
        ajax: '{{url ("mantenedores/rangocuotas/listar")}}',
        columns: [
            { data: 'rcc_id', name: 'rcc_id' },
            { data: 'rcc_inicio', name: 'rcc_inicio' },
            { data: 'rcc_fin', name: 'rcc_fin' },
            { data: 'rcc_dias', name: 'rcc_dias' },
            
        ],
        "columnDefs": [ {
            "targets": 4,
            "data": "rcc_id",
            "render": function ( data, type, full, meta ) {
              return '<a href="{{$ruta}}/editar/'+data+'" class="btn btn-warning" id="editar-{{$ruta}}" style="float:left; width:50%" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="{{$ruta}}/eliminar/'+data+'" class="btn btn-danger" id="eliminar-{{$ruta}}" style="float:left; width:50%" ><i class="fa fa-trash" aria-hidden="true"></i></a><br>';
            }
        },
        {
            "targets": 1,
            "data": "rcc_id",
            "render": function ( data, type, full, meta ) {
              return '$'+data;
            }
        },
        {
            "targets": 2,
            "data": "rcc_id",
            "render": function ( data, type, full, meta ) {
              return '$'+data;
            }
        }
        ]
    });




	
});
</script>
@endsection
