<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@php 	$ruta = "productos"; $modal = "producto"; @endphp
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadotipopies') }}
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-primary " data-toggle="modal" href='#agregar-{{$modal}}' title="Agregar nueva marca"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Productos</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
<div class="container-fluid spark-screen" >
	<h2>Listado de <small> Productos</small></h2>
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
					<th>COD.</th>
					<th>Tipo Producto</th>
					<th>Modelo</th>
					<th>Descripcion</th>
					<th>Estado</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>COD.</th>
					<th>Tipo Producto</th>
					<th>Modelo</th>
					<th>Descripcion</th>
					<th>Estado</th>
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
				<h4 class="modal-title">Nuevo Producto</h4>
			</div>

			<div class="modal-body">
				<div class="row">
				<form action="{{url('mantenedores/productos/crear')}}" method="POST" role="form" class="nuevo_producto">
					<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
							</div>
							<div class="form-group">
								<label for="txttproducto"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Tipo Producto</label>
								<div class="ui-widget">
									<input type="text" name="txttproducto" value="" placeholder="" id="buscar_tipo_productos" class="form-control">
									
								</div>
								
							</div>
							<div class="form-group">
								<label for="txtmodelo"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Modelo</label>
								<div class="ui-widget">
									<input type="text" name="txtmodelo" value="" placeholder="" id="buscar_modelos" class="form-control">
								</div>
							</div>
					
							<div class="form-group">
								<label for="txtdescripcion"><i class="fa fa-id-card-o" aria-hidden="true" ></i> descripcion</label>
								<input type="text" class="form-control" name="txtdescripcion" placeholder="" value="" >
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
        "order": [[ 0, "asc" ]],
        language: {
              url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
        },
        ajax: '{{url ("mantenedores/productos/listar")}}',
        columns: [
			{ data: 'producto_id', name: 'producto_id' },
			{ data: 'tipoproductos.tproducto_descripcion', name: 'tipo_producto'},
			{ data: 'modelos.modelo_busqueda', name: 'modelo'},
			{ data: 'producto_descripcion', name: 'producto_descripcion' },
			{ data: 'estado_id', name: 'estado_id'}
        ],
        "columnDefs": [ {
            "targets": 4,
            "data": "estado_id",
            "render": function ( data, type, row, meta ) {
              if (data == 1) return 'Activo'; else return 'Inactivo';
            }
        }
        ]
    });

});


//funcion para buscar los tipos de productos con autocompletado
$( "#buscar_tipo_productos" ).autocomplete({
    source: function( request, response ) {
        $.ajax( {
			url: "{{url ('buscar_tproductos') }}",
			dataType: "json",
			data: {
			term: request.term
			},
			success: function( data ) {
				var resultados = [];
				for (var prop in data) {
					resultados.push(data[prop])
				}

			response($.map( data, function( item ) {
			    return {
			        label: item.tproducto_id+' - '+item.tproducto_descripcion,
			        value: item.tproducto_id+' - '+item.tproducto_descripcion
			    }
			}));


			},
			select: function(event,ui){
				event.preventDefault();
				$("#buscar_tipo_productos").attr({
					name: ui.label,
					value: ui.value
				});
				
			}
        } );
    },
    minLength: 2
});

$("#buscar_tipo_productos").autocomplete( "option", "appendTo", ".nuevo_producto" )
//funcion para buscar los modelos con autocompletado
$( "#buscar_modelos" ).autocomplete({
    source: function( request, response ) {
        $.ajax( {
			url: "{{url ('buscar_modelos') }}",
			dataType: "json",
			data: {
			term: request.term
			},
			success: function( data ) {
				var resultados = [];
				for (var prop in data) {
					resultados.push(data[prop])
				}

			response($.map( data, function( item ) {
			    return {
			        label: item.modelo_id+' - '+item.modelo_busqueda,
			        value: item.modelo_id+' - '+item.modelo_busqueda
			    }
			}));


			},
			select: function(event,ui){
				event.preventDefault();
				$("#buscar_modelos").attr({
					name: ui.label,
					value: ui.value
				});
			}
        } );
    },
    minLength: 2
});
$("#buscar_modelos").autocomplete( "option", "appendTo", ".nuevo_producto" )
</script>
@endsection
