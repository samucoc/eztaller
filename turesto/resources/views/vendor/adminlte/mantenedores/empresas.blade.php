<!-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
-->

<!-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php -->
@extends('adminlte::layouts.app') 

<!-- aqui escribimos el texto que tendra nuestra pagina -->
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadoempresas') }}
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-primary " data-toggle="modal" href='#agregar-empresa' title="Agregar empresa"><i class="fa fa-plus" aria-hidden="true"></i></i> Agregar Empresa</a>
@endsection
<!-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
-->
@section('main-content')
	<div class="container-fluid spark-screen" >
	<h2>Listado de <small> Empresas</small></h2>
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
			<table class="table table-responsive " id="listar-empresas">
				<thead>
					<tr>
						<th>Rut</th>
						<th>Nombre</th>
						<th>Direccion</th>
						<th>Giro</th>
						<th>Mutual</th>
						<th>Estado</th>
						<th>Actiones</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Rut</th>
						<th>Nombre</th>
						<th>Direccion</th>
						<th>Giro</th>
						<th>Mutual</th>
						<th>Estado</th>
						<th>Actiones</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>




<div class="modal fade " id="agregar-empresa">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Nueva Empresa</h4>
			</div>

			<div class="modal-body">
				<div class="row">
						<form action="{{url('mantenedores/empresas/crear')}}" method="POST" role="form">
					<div class="col-md-12">
							<div class="form-group">
								<label for="txtrut"><i class="fa fa-id-card-o" aria-hidden="true"></i> Rut</label>
								<input type="text" class="form-control" name="txtrut" placeholder="Rut empresa" value="">
							</div>
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								

								<label for="txtnombre"><i class="fa fa-id-card-o" aria-hidden="true"></i> Nombre</label>
								<input type="text" class="form-control" name="txtnombre" placeholder="" value="">
							</div>
							<div class="form-group">
								<label for="txtdireccion"><i class="fa fa-map-marker" aria-hidden="true"></i> Direccion</label>
								<input type="text" class="form-control" name="txtdireccion" placeholder="" value="">
							</div>
							<div class="form-group">
								<label for="txtgiro"><i class="fa fa-briefcase" aria-hidden="true"></i> Giro</label>
								<input type="text" class="form-control" name="txtgiro" placeholder="" value="">
							</div>
							<div class="form-group">
								<label for="txtmutual"><i class="fa fa-ambulance" aria-hidden="true"></i> Mutual</label>
								<input type="text" class="form-control" name="txtmutual" placeholder="" value="">
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
	var tabla = $('#listar-empresas').DataTable({
        processing: true,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf','print'
        ],
        language: {
              url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
        },
        ajax: '{{url ("mantenedores/empresas/listar")}}',
        columns: [
            { data: 'empresa_rut', name: 'Rut' },
            { data: 'empresa_nombre', name: 'nombre' },
            { data: 'empresa_direccion', name: 'Direccion' },
            { data: 'empresa_giro', name: 'Giro' },
            { data: 'empresa_mutual', name: 'Mutual' },
            { data: 'empresa_estado', name: 'estado' },
        ],
        "columnDefs": [ {
            "targets": 6,
            "data": "empresa_id",
            "render": function ( data, type, full, meta ) {
              return '<a href="empresas/editar/'+data+'" class="btn btn-warning" id="editar-empresa" style="float:left; width:50%" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="empresas/eliminar/'+data+'" class="btn btn-danger" id="eliminar-empresa" style="float:left; width:50%" title="Dar de Baja"><i class="fa fa-ban" aria-hidden="true"></i></a><br>';
            }
        },
        {
            "targets": 5,
            "data": "empresa_estado",
            "render": function ( data, type, row, meta ) {
              if (data == 1) return 'Activo'; else return 'Inactivo';
            }
        }
         ]
    });




	
});
</script>
@endsection
