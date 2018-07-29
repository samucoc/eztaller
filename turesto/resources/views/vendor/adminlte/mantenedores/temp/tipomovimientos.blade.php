<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadotipomovimientos') }}
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-primary " data-toggle="modal" href='#agregar-movimiento' title="Agregar Tipo de Movimiento"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Tipo Movimiento</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
	<div class="container-fluid spark-screen" >
	<h2>Listado de <small>Tipos de Movimientos</small></h2>
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
			<table class="table table-hover" id="listar-movimientos">
				<thead>
					<tr>
						<th>ID</th>
						<th>Codigo</th>
						<th>Descripcion</th>

					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Codigo</th>
						<th>Descripcion</th>

					</tr>
				</tfoot>
			</table>
		</div>
	</div>

<div class="modal fade " id="agregar-movimiento">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Nueva Tipo de Movimiento</h4>
			</div>

			<div class="modal-body">
				<div class="row">
						<form action="{{url('mantenedores/tipomovimientos/crear')}}" method="POST" role="form">
					<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<label for="txtcodigo"><i class="fa fa-id-card-o" aria-hidden="true"></i> codigo</label>
								<input type="text" class="form-control" name="txtcodigo" placeholder="" value="">
							</div>
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<label for="txtdescripcion"><i class="fa fa-id-card-o" aria-hidden="true"></i> Descripcion</label>
								<input type="text" class="form-control" name="txtdescripcion" placeholder="" value="">
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
	var tabla = $('#listar-movimientos').DataTable({
        processing: true,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf','print'
        ],
        language: {
              url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
        },
        ajax: '{{url ("mantenedores/tipomovimientos/listar")}}',
        columns: [
            { data: 'tm_id', name: 'tm_id' },
            { data: 'tm_codigo', name: 'tm_codigo' },
            { data: 'tm_descripcion', name: 'tm_descripcion' }
        ]
    });




	
});
</script>
@endsection
