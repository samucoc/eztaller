<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@php 	$ruta = "clientes"; $modal = "cliente"; @endphp
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadotipopies') }}
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-primary " data-toggle="modal" href='#agregar-{{$modal}}' title="Agregar nueva marca"><i class="fa fa-plus" aria-hidden="true"></i> Agregar cliente</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
<div class="container-fluid spark-screen" >
	<h2>Buscar <small> Cliente</small></h2>
	
		<div class="form-group">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		</div>
		<div class="form-group">
			<label for="txtcliente">Apellido Paterno</label>
			<div class="ui-widget">
				<input type="text" name="txtcliente" value="" placeholder="" id="buscar_clientes" class="form-control">
			</div>
		</div>
		<button type="button" class="btn btn-primary btn-flat" id="cargar_cliente">Cargar Datos</button>
	
	
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

<div class="col-md-12">
	<div class="table-responsive" >
		<table class="table table-responsive" id="listar-{{$ruta}}">
			<thead>
				<tr>
					<th>COD.</th>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Rut</th>
					<th>Direccion</th>
					<th>Ciudad</th>
					<th>Barrio</th>
					<th>Localidad</th>
					<th>Fono</th>
					<th>Sector</th> 
					<th>Cupo</th>
					<th>Estado</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>COD.</th>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Rut</th>
					<th>Direccion</th>
					<th>Ciudad</th>
					<th>Barrio</th>
					<th>Localidad</th>
					<th>Fono</th>
					<th>Sector</th> 
					<th>Cupo</th>
					<th>Estado</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
</div>
<div class="modal fade " id="agregar-{{$modal}}">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Nuevo Cliente</h4>
			</div>

			<div class="modal-body">
				<div class="row">
				<form action="{{url('mantenedores/clientes/crear')}}" method="POST" role="form" class="nuevo_producto">
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
			</form>
		</div>
	</div>
</div>

@endsection

@section('mi-script')
<script type="text/javascript">


//funcion para buscar los clientes con autocompletado
$( "#buscar_clientes" ).autocomplete({
    source: function( request, response ) {
        $.ajax( {
			url: "{{url ('buscar_clientes') }}",
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
			        label: item.cliente_rut+' - '+item.cliente_nombres,
			        value: item.cliente_rut+' - '+item.cliente_nombres
			    }
			}));


			},
			select: function(event,ui){
				event.preventDefault();
				$("#buscar_clientes").attr({
					name: ui.label,
					value: ui.value
				});
			}
        });
    },
    minLength: 2
});
$("#buscar_clientes").autocomplete( "option", "appendTo", ".busqueda_cliente" );

//busca en la base de datos la informacion del cliente
$('#cargar_cliente').click(function(e){
	e.preventDefault();
	var cliente = $('#buscar_clientes').val();
	$.ajax()
	$.ajax({
		url: '{{url("mantenedores/clientes/listar")}}',
		data: {cliente: cliente},
	})
	.done(function(data) {
		console.log("success");
		console.log(data);

		$('#listar-clientes').DataTable({
        data:data,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf','print'
        ],
        language: {
              url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
        },
        columns: [
        	{ data: 'cliente_id', name: 'cliente_id' },
            { data: 'cliente_nombres', name: 'cliente_nombres' },
            { data: 'cliente_apellidos', name: 'cliente_id' },
            { data: 'cliente_rut', name: 'cliente_nombres' },
            { data: 'cliente_direccion', name: 'cliente_id' },
            { data: 'cliente_ciudad', name: 'cliente_nombres' },
            { data: 'cliente_barrio', name: 'cliente_id' },
            { data: 'cliente_localidad', name: 'cliente_nombres' },
            { data: 'cliente_fono', name: 'cliente_id' },
            { data: 'sector_id', name: 'cliente_nombres' },
            { data: 'cupo_id', name: 'cliente_id' },
            { data: 'cliente_estado', name: 'cliente_nombres' },
        ]
    });
	})
	.fail(function() {
		console.log("error, no se pudo cargar los datos. Intentente mas tarde");
	})
	.always(function() {
		console.log("complete");
	});
	
});//fin cargar cliente


</script>
@endsection
