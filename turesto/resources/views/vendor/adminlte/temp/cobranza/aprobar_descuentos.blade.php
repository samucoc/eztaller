{{--copie y pegue el siguiente codigo en cada una de sus paginas
	favor solo modifique la seccion de htmlheader_title en el apartado trans
	y la session main-content.
--}}
{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
{{--no modificar--}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
{{--para agregar el titulo de la pagina se debe agregar primero en el lang es ubicado en vendor/admin-lte-template-laravel/resources/lang/es/message.php  --}}
@section('htmlheader_title'){{ trans('adminlte_lang::message.aplicaciondescuentos') }} @endsection

{{--aqui escribe tu css--}}
@section('mi-css') 
<style type="text/css">
	.btn-app:hover{
    color:#f56954;
    box-shadow: 0 4px 7px rgba(0,0,0,.4);
  }
</style>
@endsection

{{--aqui escribe el titulo de la pagina la cual se vera dentro del contenido--}}
@section('contentheader_title')
<div class="col-md-4"><i class="fa fa-file-text-o" aria-hidden="true"></i> Aprobacion de Descuentos</div>
<div class="col-md-8">
	<form action="" method="POST" class="form-inline" role="form" id="form_buscar_descuentos">
		<div class="form-group">
    <label class="sr-only" for="txtfdesde">Periodo: </label>
    <div class="input-group">
        	<input name="txtfdesde" id="fdesde" type="text" class="form-control col-xs-3 col-md-3 fecha_tope">
        	<span class="input-group-addon">al</span>
        	<input name="txtfhasta" id="fhasta" type="text" class="form-control col-xs-3  col-md-3 fecha_tope">
        </div>
  	</div>
	  <div class="form-group">
	    <label class="sr-only" for="txtsector">Sector</label>
	    <input type="text" name="txtsector" class="form-control" id="txtsector" placeholder="Sector">
	  </div>
	  <div class="form-group">
			<div class="">
				<button type="submit" class="btn btn-flat btn-info">Buscar</button>
			</div>
		</div>
	</form>
</div>
@endsection

{{--aqui escribe la descripcion de la pagina, esta ira junto con el titulo de la seccion anterior--}}
@section('contentheader_description') @endsection

{{-- aqui escribiremos todo el codigo para cada pagina,la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
--}}
@section('main-content')
<div class="container-fluid spark-screen" id="table-general">

	{{-- seccion para mostrar mensaje de error --}}
	<div class="row box_mensaje_error" style="display: none;">
		<div class="col-md-12">
			<div class="col-md-4 text-yellow ">
				<h1 class="pull-right"><i class="fa fa-exclamation-triangle fa-5x " aria-hidden="true"></i></h1>
			</div>
			<div class="col-md-8">
				<h1 class="text-gray">Oooops!</h1>
				<h2 class="text-gray">El Folio no existe o se ingreso mal!</h2>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="box box-info" style="display: none;">
			<form action="" method="POST" class="form-horizontal" role="form" id="form_listado_descuentos">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<div class="box-header with-border box_descuentos_por_aprobar">
		      		<h3 class="box-title"><i class="fa fa-th-list"></i> Listado de Descuentos pendientes de aprobacion</h3>
			      	<div class="box-tools pull-right">
			        	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			      	</div>
		    </div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-hover" id="tabla_descuentos">
							<thead>
								<tr>
									<th>N°</th>
									<th><input type="checkbox" name="txttodos" id="txttodos" data-toggle="tooltip" data-placement="top" title="Seleccionar Todos"></th>
									<th>Fecha Aprobacion</th>
									<th>fecha Registro</th>
									<th>folio</th>
									<th>Sector</th>
									<th>Vendedor</th>
									<th>cliente</th>
									<th>total Venta</th>
									<th>Descuento</th>
									<th>Usuario</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary btn-flat">Aprobar</button>
					<button type="button" class="btn btn-danger btn-flat" id="btn_rechazar_descuentos">rechazar</button>
				</div>
			</form>
		</div>
  </div>
</div>

@endsection


@section('mi-script')
<script type="text/javascript">

$('#btn_rechazar_descuentos').click(function(e){
	e.preventDefault();
	var token = $('#form_listado_descuentos input:hidden').val();
	var seleccion = [];
	//recorremos todos los checkbox del formulario para solo enviar los que esten chequeados
	$('#form_listado_descuentos input:checkbox').each(function(){
		//validamos que no se envien el checkbox que selecciona todos los demas checkbox del formulario
		if($(this).attr('id') != 'txttodos'){
			//validamos si el checkbox esta seleccionado o no
			if($(this).is(':checked')){
				//si esta seleccionado lo guardamos en una variable tipo arreglo
				seleccion.push($(this).val());
			}
		}
	});

	$.ajax({
			beforeSend:function(){
			},
			url: '{{url("cobranza/aprobacion_de_descuentos/rechazar_descuentos")}}',//ruta donde se enviara la informacion'
			type: 'PUT',
			data: {seleccion:seleccion,_token:token},//dato con la informacion
			error   : function ( jqXhr, json, errorThrown ){
	            var errors = jqXhr.responseJSON;
	            $.each( errors, function( key, value ) {
	                $.notify({
	                // options
	                  title: '<strong>Upps!</strong>',
	                  icon: 'fa fa-exclamation-circle',
	                  message: value,
	                },{
	                // settings
	                  type: 'danger',
	                });
	            }); 
	          }
		})
		.done(function(data) {
			console.log("success");
			$.notify({
				// opciones
				title: '<strong>Listo!</strong>',
				icon: 'fa fa-check-circle-o fa-2x',
				message: 'Descuentos Rechazados',
			},{
				// configuracion
				type: 'success'
			});
			$('#tabla_descuentos tbody').html('');//limpiamos la tabla en caso de que se encuentre con datos
		})
		.fail(function(data) {
			console.log("error");
		})
		.always(function(data) {
			console.log("complete");
		});
});


$('#form_listado_descuentos').submit(function(e){
	e.preventDefault();
	var token = $('input:hidden',this).val();
	var seleccion = [];
	//recorremos todos los checkbox del formulario para solo enviar los que esten chequeados
	$('input:checkbox',this).each(function(){
		//validamos que no se envien el checkbox que selecciona todos los demas checkbox del formulario
		if($(this).attr('id') != 'txttodos'){
			//validamos si el checkbox esta seleccionado o no
			if($(this).is(':checked')){
				//si esta seleccionado lo guardamos en una variable tipo arreglo
				seleccion.push($(this).val());
			}
		}
	});

	$.ajax({
			beforeSend:function(){
			},
			url: '{{url("cobranza/aprobacion_de_descuentos/aprobar_descuentos")}}',//ruta donde se enviara la informacion'
			type: 'PUT',
			data: {seleccion:seleccion,_token:token},//dato con la informacion
			error   : function ( jqXhr, json, errorThrown ){
	            var errors = jqXhr.responseJSON;
	            $.each( errors, function( key, value ) {
	                $.notify({
	                // options
	                  title: '<strong>Upps!</strong>',
	                  icon: 'fa fa-exclamation-circle',
	                  message:value,
	                },{
	                // settings
	                  type: 'danger',
	                });
	            }); 
	          }
		})
		.done(function(data) {
			console.log("success");
			$.notify({
				// opciones
				title: '<strong>Listo!</strong>',
				icon: 'fa fa-check-circle-o fa-2x',
				message: 'Descuentos Autorizados',
			},{
				// configuracion
				type: 'success'
			});
			$('#tabla_descuentos tbody').html('');//limpiamos la tabla en caso de que se encuentre con datos
		})
		.fail(function(data) {
			console.log("error");
		})
		.always(function(data) {
			console.log("complete");
		});
});


$(document).on('change','input:checkbox',function(){
	var $fila = $(this).closest('tr');//obtenemos el row del checkbox donde se hizo click
	var iden = $fila.find('td:first').text();//obtenemos el numero de ese row
	//si el checkbox no esta seleccionamos hacemos lo siguiente
	if( $(this).is(':checked')){
		agregarfecha(this);
	}else{
		$('#'+iden).html('');
	}
});

//evento que llama a la funcion validarcheckbox para seleccionarlos todos o desmarcarlos si es el caso
$(document).on('change','#txttodos',function(){
	validarcheckbox()
});

//funcion para recorrer los checkbox del formulario para verificar si estan checkeados o no
function validarcheckbox(){
	$('#form_listado_descuentos input:checkbox').each(function(){
		if($(this).attr('id') != 'txttodos'){
			if($(this).is(':checked')){
				$(this).prop('checked',false);
				var $fila = $(this).closest('tr');//obtenemos el row del checkbox donde se hizo click
				var iden = $fila.find('td:first').text();//obtenemos el numero de ese row
				$('#'+iden).html('');
			}else{
				$(this).prop('checked',true);
				agregarfecha(this);
			}
		}

	});
}

//funcion para agregar la fecha de aprobracion del descuento
function agregarfecha(e){
		var $fila = $(e).closest('tr');//obtenemos el row del checkbox donde se hizo click
		var iden = $fila.find('td:first').text();//obtenemos el numero de ese row
		var fecha = new Date(); //instanciamos una nueva fecha
		var dia = fecha.getDate();//obtenemos el dia
		var mes = fecha.getMonth();//obtenemos el mes
		var anio = fecha.getYear();//obtenemos el año
		var hoy = ((dia < 10 )? '0'+dia: dia) +'/'+( ( (mes+1) < 10 )? '0'+(mes +1):(mes +1))+'/'+anio;//concatenamos el dia + mes + anio
		$('#'+iden).html(hoy);//le asignamos la 
}


$('#form_buscar_descuentos').submit(function(e){
	e.preventDefault();
	$.ajax({
			beforeSend:function(){
				$('#tabla_descuentos tbody').html('');//limpiamos la tabla en caso de que se encuentre con datos
			},
			url: '{{url("cobranza/aprobacion_de_descuentos/buscar_descuentos")}}',//ruta donde se enviara la informacion'
			data: $('#form_buscar_descuentos').serialize(),//dato con la informacion
			error   : function ( jqXhr, json, errorThrown ){
	            var errors = jqXhr.responseJSON;
	            $.each( errors, function( key, value ) {
	                $.notify({
	                // options
	                  title: '<strong>Upps!</strong>',
	                  icon: 'fa fa-exclamation-circle',
	                  message:value,
	                },{
	                // settings
	                  type: 'danger',
	                });
	            });
	          }
		})
		.done(function(data) {
			console.log("success");
			
			if(data == 0){
				$.notify({
        // options
          title: '<strong>Upps!</strong>',
          icon: 'fa fa-exclamation-circle',
          message:'No se encontraron descuentos para la fecha señalada, Intente con otro periodo',
        },{
        // settings
          type: 'danger',
        });
			}else{
				for (var i = 0; i < data.length; i++) {
					$('#tabla_descuentos').append('<tr><td>'+ (i + 1) +'</td><td><input type="checkbox" name="seleccion[]" value="'+data[i].descuento_id+'"></td><td id="'+ (i + 1) +'"></td><td>'+formatofecha(data[i].descuento_fecha)+'</td><td>'+data[i].venta_id+'</td><td>'+data[i].sector_id+'</td><td>'+data[i].ventas.trabajadores.trabajador_nombres+' '+data[i].ventas.trabajadores.trabajador_ap+'</td><td>'+data[i].ventas.clientes.cliente_nombres+' '+data[i].ventas.clientes.cliente_apellidos+'</td><td>'+data[i].ventas.venta_total+'</td><td>'+data[i].descuento_monto+'</td><td>'+data[i].creado_por+'</td></tr>');
				}
			}

			if ( $('#tabla_descuentos').css('display')!='block' ) {
					$('#tabla_descuentos').toggle(100);
			}
		})
		.fail(function(data) {
			console.log("error");
		})
		.always(function(data) {
			console.log("complete");
		});
})

</script>
@endsection