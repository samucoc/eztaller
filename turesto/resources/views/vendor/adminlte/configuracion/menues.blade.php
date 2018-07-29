{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.listadomenu') }}
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-primary " data-toggle="modal" href='#agregar-menu' title="Agregar Menu"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Menu</a>
@endsection
{{-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
--}}
@section('main-content')
	<div class="container-fluid spark-screen" >
		<h2>Listado de <small> Menus</small></h2>
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
			<table class="table table-hover" id="listar-menues">
				<thead>
					<tr>
						<th>Descripcion</th>
						<th>Icono</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Descripcion</th>
						<th>Icono</th>
						<th>Acciones</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

<div class="modal fade " id="agregar-menu">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Nueva Menu</h4>
			</div>

			<div class="modal-body">
				<div class="row">
						<form action="{{url('mantenedores/menues/crear')}}" method="POST" role="form">
					<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<label for="txtdescripcion"><i class="fa fa-id-card-o" aria-hidden="true"></i> descripcion </label>
								<input type="text" class="form-control" name="txtdescripcion" placeholder="" value="">
							</div>
							<div class="form-group">
								<label for="txticono"><i class="fa fa-id-card-o" aria-hidden="true"></i> Icono </label>
								<input type="text" class="form-control" name="txticono" placeholder="" value="" aria-describedby="helpBlock">
								<span id="helpBlock" class="help-block">Para ingresar el icono favor dirijirse a <a href="http://fontawesome.io/icons/" title="Font Awesome" target="_blank">Font Awesome</a>, y solo copiar  "fa-id-card-o" a modo de ejemplo.</span>
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
	var tabla = $('#listar-menues').DataTable({
        processing: true,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf','print'
        ],
		"order": [[ 1, "asc" ]],
        language: {
              url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
        },
        ajax: '{{url ("mantenedores/menues/listar")}}',
        columns: [
            { data: 'menu_descripcion', name: 'descripcion' },
            { data: 'menu_icon', name: 'icono' }
        ],
        "columnDefs": [ {
            "targets": 2,
            "data": "menu_id",
            "render": function ( data, type, full, meta ) {
              return '<a href="menues/editar/'+data+'" class="btn btn-warning" id="editar-menues" style="float:left; width:50%" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="menues/eliminar/'+data+'" class="btn btn-danger" id="eliminar-menues" style="float:left; width:50%" ><i class="fa fa-trash" aria-hidden="true"></i></a><br>';
            }
        },
        {
            "targets": 1,
            "data": "menu_icon",
            "render": function ( data, type, full, meta ) {
              return '<i class="fa '+data+' aria-hidden="true"></i>';
            }
        }
        ]
    });




	
});
</script>
@endsection
