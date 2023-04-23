<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@php 	$ruta = "productosdetalles"; $modal = "productosdetalle"; @endphp
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadotipopies') }}
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-primary " data-toggle="modal" href='#agregar-{{$modal}}' title="Agregar nueva marca"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Detalle de producto</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
<div class="container-fluid spark-screen" >
	<h2>Listado de <small> Detalle de Productos</small></h2>
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
					<th>Producto</th>
					<th>Detalle</th>
					<th>Precio</th>
					<th>Estado</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>COD.</th>
					<th>Producto</th>
					<th>Detalle</th>
					<th>Precio</th>
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
				<h4 class="modal-title">Nuevo Detalle de Producto</h4>
			</div>

			<div class="modal-body">
				<div class="row">
				<form action="{{url('mantenedores/productosdetalles/crear')}}" method="POST" role="form" class="nuevo_productodetalle">
					<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
							</div>
							<div class="form-group">
								<label for="txtproducto"><i class="fa fa-id-card-o" aria-hidden="true" ></i>Producto</label>
								<div class="ui-widget">
									<input type="text" name="txtproducto" value="" placeholder="" id="buscar_productos" class="form-control">
								</div>
							</div>
					
							<div class="form-group">
								<label for="txtdetalle"><i class="fa fa-id-card-o" aria-hidden="true" ></i> detalle</label>
								<input type="text" class="form-control" name="txtdetalle" placeholder="" value="" >
							</div>
							<div class="form-group">
								<label for="txtprecio"><i class="fa fa-id-card-o" aria-hidden="true" ></i> Precio</label>
								<input type="text" class="form-control" name="txtprecio" placeholder="" value="" >
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
        ajax: '{{url ("mantenedores/productosdetalles/listar")}}',
        columns: [
			{ data: 'productod_id', name: 'productod_id' },
			{ data: 'productos.producto_descripcion', name: 'producto_descripcion'},
			{ data: 'productod_descripcion', name: 'productod_descripcion'},
			{ data: 'productod_precio', name: 'productod_precio' },
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
$( "#buscar_productos" ).autocomplete({
    source: function( request, response ) {
        $.ajax( {
			url: "{{url ('buscar_productos') }}",
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
			        label: item.producto_id+' - '+item.producto_descripcion,
			        value: item.producto_id+' - '+item.producto_descripcion
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
    minLength: 1 //cuantos caracteres necesita para comenzar con el autocompletado
});

//como es un modal se necesita para que funcione el autocompletado
$("#buscar_productos").autocomplete( "option", "appendTo", ".nuevo_productodetalle" )
</script>
@endsection
