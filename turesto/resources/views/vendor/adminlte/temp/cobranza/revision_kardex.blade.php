{{--copie y pegue el siguiente codigo en cada una de sus paginas
	favor solo modifique la seccion de htmlheader_title en el apartado trans
	y la session main-content.
--}}
{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
{{--no modificar--}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
{{--para agregar el titulo de la pagina se debe agregar primero en el lang es ubicado en vendor/admin-lte-template-laravel/resources/lang/es/message.php  --}}
@section('htmlheader_title'){{ trans('adminlte_lang::message.revisionkardex') }} @endsection

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
<div class="col-md-8"><i class="fa fa-file-text-o" aria-hidden="true"></i> Revision de Kardex</div>
<div class="col-md-4">
	<div class="col-md-12">
		<div class="input-group">
	    	<input type="text" class="form-control" placeholder="Folio..." id="txtfoliobuscar" tabindex="1">
	    	<span class="input-group-btn">
	    		<button class="btn btn-secondary btn-info" id="buscar_folio" type="button" tabindex="2">Buscar</button>
	      	</span>
	    </div>
	</div>
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

	{{--datos del cliente y fecha de ultima revision--}}
	<div class="row">
		<div class="col-md-12">
		  <div class="box box-info box_datos" style="display: none;">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-inbox"></i> Datos</h3>
		      <div class="box-tools pull-right">
		        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
		        </button>
		      </div>
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body" id="datos_cliente">
		      <div class="row">
		        <div class="col-md-3">
			        <div class="box box-widget widget-user-2">
				        <div class="row">
					        <h3 class="text-center" id="perfil_nombre">Nadia Carmichael</h3>
					        <h5 class="text-center" id="perfil_rut">99.999.999-9</h5>
					        <p class="text-muted text-center" id="perfil_estado"></p>
				        </div>
				        <br>
				        <div class="row">
					        <div class="col-md-6 col-lg-12 col-sm-6 col-xs-12">
					        	<div class="col-md-6 col-sm-6 col-xs-6">
					        		<p class="text-left"><i class="fa fa-user-plus"></i> Miembro desde</p>
					        	</div>
					        	<div class="col-md-6 col-sm-6 col-xs-6">
		            				<p class="text-right" id="perfil_creado_desde"></p>	
					        	</div>
		            		</div>
				        </div>
				        <div class="row">
							<div class="col-md-6 col-lg-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-6">
			            			<p class="text-left"><i class="fa fa-lock"></i> Bloqueado</p>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 text-right" id="perfil_bloqueado">
								<select name="txtbloqueado" id="txtbloqueado" class="form-control txt_bloqueado hidden-print">
									<option value="1">NO</option>
									<option value="2">SI</option>
								</select>
								<p class="visible-print hidden" id="bloqueado"></p>
								</div>
		            		</div>
				        </div>
						<div class="row">
							<div class="col-md-12">
							<br>
								<button class="btn btn-flat bg-teal center-block hidden-print" id="btn-actualizar-cliente" disabled="disabled">Actualizar Datos</button>
								<br>
							</div>
						</div>
			        </div>
		        </div>
				
		        <div class="col-md-9">
		        	<div class="col-md-12">
		        		<div class="row">
			            	<div class="col-md-6 col-lg-4 col-sm-6 col-xs-6">
			            		<p><i class="fa fa-map-marker"></i> Direccion</p>
			            		<p id="perfil_direccion"></p>
			            	</div>
			            	<div class="col-md-6 col-lg-4 col-sm-6 col-xs-6">
			            		<p><i class="fa fa-globe"></i> Ciudad</p>
			            		<p id="perfil_ciudad"></p>
			            	</div>
		        		</div>
		        		<div class="row">
			            	<div class="col-md-6 col-lg-4 col-sm-6 col-xs-6">
			            		<p><i class="fa fa-compass"></i> Barrio</p>
			            		<p id="perfil_barrio"></p>
			            	</div>
			            	<div class="col-md-6 col-lg-4 col-sm-6 col-xs-6">
			            		<p><i class="fa fa-location-arrow"></i> Localidad</p>
			            		<p id="perfil_localidad"></p>
			            	</div>
		        		</div>
		            	<div class="row">
			            	<div class="col-md-6 col-lg-4 col-sm-6 col-xs-6" id="perfil_telefono">
			            		<p><i class="fa fa-mobile"></i> Telefono</p>
			            		<p class="visible-print hidden" id="telefono"></p>
			            		<input type="number" name="txttelefono" id="txttelefono" value="" class="form-control txt_telefono hidden-print">
			            	</div>
			            	<div class="col-md-6 col-lg-4 col-sm-6 col-xs-6" id="perfil_cupo">
			            		<p><i class="fa fa-money"></i> Cupo</p>
			            		<p class="visible-print hidden" id="cupo"></p>
			            		<select name="txtcupo" id="txtcupo" class="form-control txt_cupo hidden-print">
			            		<option>Seleccione...</option>
			            		@foreach($cupos as $cupo)
									<option value="{{$cupo->cupo_codigo}}">{{$cupo->cupo_monto}}</option>
			            		@endforeach
			            		</select>
		            			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<input type="hidden" name="txtcliente" value="" id="txtcliente" />
			            	</div>
		            	</div>
		        	</div>
		        	<div class="col-md-12">
		        		<hr style="border: 1px solid;opacity: 0.3;">
		        	</div>
		        	<div class="col-md-12 hidden-print">
		        		<p class="text-left" ><strong>Revision</strong></p>
		        		<div class="table-responsive ">
		        		<form action="" method="POST" class="form-horizontal" role="form" id="form_revision_kardex">
		        			<table class="table ">
		        				<tbody>
		        					<tr>
		        						<td>Ultima Revision</td>
		        						<td id="venta_revision"></td>
		        					</tr>
		        					<tr>
		        						<td>Revisado el dia</td>
		        						<td><input type="text" name="txtfecharevision" id="fecha_revision" class="form-control fecha_tope">
											<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
											<input type="hidden" name="txtventa" value="" id="txtventa" />

		        						</td>
		        					</tr>
		        				</tbody>
		        			</table>
		        		</form>
		        		</div>
		        	</div>
		        </div>
		      </div>
		    </div>
		    <div class="box-footer">
		      <div class="row">
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block border-right">
		            <a class="btn btn-app"  id="btn-reset-form">
		              <i class="fa fa-refresh"></i> Nueva Revision
		            </a>
		          </div>
		        </div>
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block border-right">
		            <a class="btn btn-app" id="btn-imprimir-tarjeta" >
		              <i class="fa fa-print"></i> Imprimir Tarjeta
		            </a>
		          </div>
		        </div>
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block border-right">
		            <a class="btn btn-app" id="btn-otros-folios">
		              <i class="fa fa-id-card-o"></i> Otros Folios
		            </a>
		          </div>
		        </div>
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block">
		            <a class="btn btn-app" id="btn-grabar-revision">
		              <i class="fa fa-floppy-o"></i> Grabar Revision
		            </a>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

	<div class="box box-success box_datos_varios" style="display: none;">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-inbox"></i> Datos</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div role="tabpanel">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#abonos" aria-controls="home" role="tab" data-toggle="tab">Abonos</a></li>
					<li role="presentation"><a href="#abonos_unificados" aria-controls="tab" role="tab" data-toggle="tab">Abonos Unificados</a></li>
					<li role="presentation"><a href="#cuadratura" aria-controls="tab" role="tab" data-toggle="tab">Cuadratura</a></li>
					<li role="presentation"><a href="#productos" aria-controls="tab" role="tab" data-toggle="tab">Productos</a></li>
					<li role="presentation"><a href="#devoluciones" aria-controls="tab" role="tab" data-toggle="tab">Devoluciones</a></li>
					<li role="presentation"><a href="#traspasos" aria-controls="tab" role="tab" data-toggle="tab">Traspasos</a></li>
				</ul>
			
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="abonos">
						<div class="table-responsive">
							<table class="table no-margin" id="tabla_abonos">
								<thead>
									<tr>
										<th>N°</th>
										<th>F. Pago</th>
										<th>Abono</th>
										<th>saldo Venta</th>
										<th>Cuota</th>
										<th>F. Venc</th>
										<th>Monto Cuota</th>
										<th>Saldo Cuota</th>
										<th>Dias Atraso</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="abonos_unificados">
						<div class="table-responsive">
							<table class="table no-margin" id="tabla_abonos_unificados">
								<thead>
									<tr>
										<th>cobrador</th>
										<th>Supervisor</th>
										<th>Abono</th>
										<th>Fecha Abono</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="cuadratura">
						<div class="table-responsive">
							<table class="table no-margin" id="tabla_cuadratura">
								<thead>
									<tr>
										<th>Cuota</th>
										<th>Monto Cuota</th>
										<th>Abonado</th>
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="productos">
						<div class="table-responsive">
							<table class="table no-margin" id="tabla_productos">
								<thead>
									<tr>
										<th>Item</th>
										<th>Codigo</th>
										<th>Descripcion</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot></tfoot>
							</table>
						</div>
					</div>
					
					<div role="tabpanel" class="tab-pane" id="devoluciones">
						<div class="table-responsive">
							<table class="table no-margin" id="tabla_devoluciones">
								<thead>
									<tr>
										<th>Item</th>
										<th>Fecha</th>
										<th>Folio</th>
										<th>Guia</th>
										<th>codigo</th>
										<th>Descripcion</th>
										<th>Cantidad</th>
										<th>Valor</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
								</tfoot>
							</table>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="traspasos">
						<div class="table-responsive">
							<table class="table no-margin" id="tabla_traspasos">
								<thead>
									<tr>
										<th>cobrador</th>
										<th>Supervisor</th>
										<th>Abono</th>
										<th>Fecha Abono</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- seccion para ver la informacion de la venta  --}}
	<div class="row box_datos_venta" style="display: none;">
		<div class="col-md-12" id="tabla_ventas">
			<div class="box box-danger">
	          <div class="box-header with-border">
	            <h3 class="box-title">Datos Venta</h3>
	            <div class="box-tools pull-right">
	              <button type="button" class="btn btn-box-tool hidden-print" data-widget="collapse"><i class="fa fa-minus"></i></button>
	            </div>
	          </div>
	          <!-- /.box-header -->
	          <div class="box-body">
				<div class="table-responsive">
					<table class="table" id="tabla_datos_ventas">
						<tbody>
						</tbody>
					</table>
				</div>
	            <!-- /.table-responsive -->
	          </div>
	          <!-- /.box-body -->
	          <div class="box-footer clearfix">
	            <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('tabla_ventas')">
	      			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
	    			</a>
	          </div>
	          <!-- /.box-footer -->
	        </div>
		</div>
	</div>
</div>
@endsection

@section('mi-script')

<script type="text/javascript">
//actualizar cupo de cliente
$(document).on("change",".txt_cupo, .txt_telefono, .txt_bloqueado", function(){
	$('#btn-actualizar-cliente').removeAttr('disabled');
});

//funcion para actualizar el cupo del cliente
//nota
//no se pueden modificar los demas datos del cliente ya que sera unicamente por el mantenedor de clientes
$('#btn-actualizar-cliente').click(function(){
	var cupo = $('#txtcupo').val();//obtenemos el cupo nuevo
	var telefono = $('#txttelefono').val();
	var bloqueado = $('#txtbloqueado').val();
	var token = $('#perfil_cupo input[name="_token"]').val();
	var cliente = $('#txtcliente').val();
	$.ajax({
		beforeSend:function(){
		},
		url: '{{url("cobranza/revision_kardex/actualizar_cupo")}}',//ruta donde se enviara la informacion
		data: {cupo: cupo,_token:token,cliente:cliente,telefono:telefono,bloqueado:bloqueado},//dato con la informacion
		type:'PUT',
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
			message: 'Datos Actualizado',
		},{
			// configuracion
			type: 'success'
		});
	})
	.fail(function(data) {
		console.log("error");
	})
	.always(function(data) {
		console.log("complete");
	});
});


//funcion para buscar el abono en el sistema
$('#buscar_folio').click(function(event) {
	/* Act on the event */
	var folio = $('#txtfoliobuscar').val();//obtenemos el folio
	$.ajax({
		beforeSend:function(){
			//antes de realizar una nueva consulta borramos el contenido de la tabla de los datos de la venta
			document.getElementById('tabla_datos_ventas').innerHTML='';
			$('#tabla_abonos tbody').html('');
		},
		url: '{{url("cobranza/ingreso_cobranza/buscar_folio")}}',//ruta donde se enviara la informacion
		data: {folio: folio},//dato con la informacion 
	})
	.done(function(data) {
		console.log("success");
		{{-- si la consulta devuelve 1, no se encontro nada y mostrara el mensaje de error, de lo contrario cargara la info --}}
		if (data == 1) {
			//si el div box_profile y box_abonos esta visible se ocultan
			if ( $('.box_datos, .box_datos_varios, .box_datos_venta').css('display')=='block' ) {
				$('.box_datos, .box_datos_varios, .box_datos_venta').toggle(100);
			}
			//si el div box_mensaje_error esta oculto lo muestra
			if ($('.box_mensaje_error').css('display') != 'block') {
				$('.box_mensaje_error').toggle(100);
			}

		} else {

			$('#txtventa').val(data[0].venta_id);
			{{--comenzamos a llenar los campos con datos
				creamos variables para ser utilizadas mas tarde--}}
			var abonos = 0;
			var saldo  = 0;
			{{--sumamos todos los abonos--}}
			for (var i = 0; i < data[0].abonos.length; i++) {
				abonos = abonos + data[0].abonos[i].abono_monto;
			}

			if(data[0].descuentos.length != 0){
				if(data[0].descuentos[0].descuento_autorizado == 1){
					{{-- calculamos el saldo pendiente restando el total de la venta - el total de abonos - descuentos --}}
					saldo = data[0].venta_total - abonos - data[0].descuentos[0].descuento_monto;
					abonos= abonos + data[0].descuentos[0].descuento_monto;
					console.log(abonos);
					console.log(saldo);
				}else{
					{{-- calculamos el saldo pendiente restando el total de la venta - el total de abonos --}}
					saldo = data[0].venta_total - abonos;
				}
			}else{
					{{-- calculamos el saldo pendiente restando el total de la venta - el total de abonos --}}
					saldo = data[0].venta_total - abonos;
			}

			{{--verificamos si los abonos son iguales al la venta total--}}
			{{--si es 'si' quiere decir que la venta esta cancelada--}}
			{{--pasamos a mostrar un mensaje señalando que la venta ya se encuentra cancelada--}}
			if (abonos == data[0].venta_total) {
				$.notify({
					// opciones
					title: '<strong>Venta Cancelada</strong>',
					icon: 'fa fa-check-circle-o fa-2x',
					message: 'La venta no presenta saldos pendiente',
				},{
					// configuracion
					type: 'success'
				});
				$('#fecha_revision').attr('disabled','disabled');
				$('#btn-grabar-revision').attr('disabled','disabled');
			}

		//carga de datos del cliente
		$('#perfil_nombre').html(data[0].clientes.cliente_nombres);
		$('#perfil_rut').html(data[0].clientes.cliente_rut);
		if (data[0].clientes.cliente_estado = 1) {
			$('#perfil_estado').html('<i class="fa fa-circle text-success" aria-hidden="true"></i> Activo');
		} else {
			$('#perfil_estado').html('<i class="fa fa-circle text-danger" aria-hidden="true"></i> Inactivo');
		}
		if (data[0].clientes.cliente_direccion == "") {
			$('#perfil_direccion').html('No Disponible');
		} else {
			$('#perfil_direccion').html(''+data[0].clientes.cliente_direccion+'');
		}
		if (data[0].clientes.cliente_ciudad =="") {
			$('#perfil_ciudad').html('No Disponible');
		} else {
			$('#perfil_ciudad').html(''+data[0].clientes.cliente_ciudad+'');
		}
		if (data[0].clientes.cliente_barrio =="") {
			$('#perfil_barrio').html('No Disponible');
		} else {
			$('#perfil_barrio').html(''+data[0].clientes.cliente_barrio+'');
		}
		if (data[0].clientes.cliente_localidad =="") {
			$('#perfil_localidad').html('No Disponible');
		} else {
			$('#perfil_localidad').html(''+data[0].clientes.cliente_localidad+'');
		}
		if (data[0].clientes.cliente_fono =="") {
			$('#perfil_telefono').append('<p>No Disponible</p>');
		} else {
			$('#txttelefono').val(data[0].clientes.cliente_fono);
			$('#telefono').html(data[0].clientes.cliente_fono);
		}
		if (data[0].clientes.cliente_linea_credito == null) {
			$('#perfil_cupo').append('<p>No Disponible</p>');
		} else {
			$('#txtcupo').val(data[0].clientes.cliente_linea_credito);
			$('#cupo').html($('#txtcupo option:selected').html());
		}
		if (data[0].clientes.cliente_bloqueado =="") {
			$('#perfil_bloqueado').html('No Disponible');
		} else {
			//seleccionamos el estado bloquado asignado al cliente
			if (data[0].clientes.cliente_bloqueado == 1) {
				$('#txtbloqueado').val('1');
				$('#bloqueado').html('NO');
			} else {
				$('#txtbloqueado').val('2');
				$('#bloqueado').html('SI');
			}
		}
		if (data[0].clientes.created_at == "") {
			$('#perfil_creado_desde').html('No Disponible');
		} else {
			var fecha_creacion = formatofecha(data[0].clientes.created_at);
			$('#perfil_creado_desde').html(''+fecha_creacion+'');
		}
		if (data[0].venta_fecha_revision == "") {
			$('#venta_revision').html('No se ha realizado la primera revision');
		} else {
			var fecha_ultima_revision = formatofecha(data[0].venta_fecha_revision);
			$('#venta_revision').html(''+fecha_ultima_revision+'');
		}

		//cargamos el id del cliente
		$('#txtcliente').val(data[0].clientes.cliente_id);

		//carga de datos de mis abonos
		var saldo_venta       = data[0].venta_total;
		var saldo_cuota       = 0;
		var dias              = 0;
		var dia_ini           = 0;
		var dia_fin           = 0;
		var dias_atraso       = 0;
		var hoy               = new Date();
		var dia               = (hoy.getDate()<10)? '0'+hoy.getDate():hoy.getDate();
		var mes               = ((hoy.getMonth()+1)<10)?'0'+(hoy.getMonth()+1):(hoy.getMonth()+1);
		hoy                   = hoy.getFullYear()+'-'+mes+'-'+dia;
		var fcorr             = 0;//fecha para comparar los abonos unificados
		var ultfcorr          = null;//aqui guardaremos lel ultimo correlativo mostrado para que no se repita
	

		for (var i = 0; i < data[0].abonos.length; i++) {
				//abonos unificados
				var sumaabonos = 0;//creamos una variable para sumar los abonos
				var correlativo = data[0].abonos[i].abono_correlativo;//asignamos el correlativo que se evaluara
				//proceso para unificar los abonos
				for (var x = 0; x < data[0].abonos.length; x++) {
						if (data[0].abonos[x].abono_correlativo == correlativo) {
							sumaabonos = sumaabonos + data[0].abonos[x].abono_monto;//sumamos sumaabonos + el abono
							fcorr      = data[0].abonos[x].abono_correlativo;
						}
				}
				//validamos que el correlativo actual no se igual al ultimo correlativo que se imprimio
				//asi evitamos que se impriman dos veces el mismo abono correlativo
				if (fcorr != ultfcorr) {
					//mostramos los abonos unificados
					$('#tabla_abonos_unificados tbody').append('<tr><td>'+(data[0].abonos[i].abono_cobrador +'-'+data[0].abonos[i].cobrador.trabajador_nombres)+'</td><td>'+(data[0].abonos[i].abono_supervisor +'-'+data[0].abonos[i].supervisor.trabajador_nombres)+'</td><td>'+sumaabonos+'</td><td>'+data[0].abonos[i].abono_fecha_pago+'</td></tr>');					
					ultfcorr = data[0].abonos[i].abono_correlativo;
				}
				//fin abonos unificados
		
				//calculo de abonos
				//si el saldo_cuota es igual a 0 le asignamos el valor de la cuota de la posicion en la que se encuentre
				if (saldo_cuota == 0 ) {
					saldo_cuota = data[0].cuotas[data[0].abonos[i].abono_cuota -1].cuota_debe;
				}
				//vamos restando de la cuota el monto del abono para obtener el saldo 
				saldo_venta = saldo_venta - data[0].abonos[i].abono_monto;

				//convertimos la fecha de pago y vencimietno de string a date
				dia_ini = new Date(data[0].abonos[i].abono_fecha_venc);
				dia_fin = new Date(data[0].abonos[i].abono_fecha_pago);
				//hacemos la resta entre la fecha de vencimiento y la fecha de pago
				//para obtener la diferencia
				dias = dia_ini - dia_fin;
				//ya obtenida la diferencia se convierte en dias
				dias_atraso = Math.floor(dias/(1000*24*60*60));

				//procedemos a listar todos los abonos
				$('#tabla_abonos tbody').append('<tr><td>'+ (i+1) +'</td><td>'+formatofecha(data[0].abonos[i].abono_fecha_pago)+'</td><td>'+data[0].abonos[i].abono_monto+'</td><td>'+saldo_venta+'</td><td>'+data[0].abonos[i].abono_cuota+'</td><td>'+formatofecha(data[0].abonos[i].abono_fecha_venc)+'</td><td>'+data[0].cuotas[data[0].abonos[i].abono_cuota -1].cuota_debe+'</td><td>'+(saldo_cuota - data[0].abonos[i].abono_monto)+'</td><td>'+ dias_atraso +'</td><td></td></tr>');

				//vamos disminuyendo el saldo de cada cuota a medida se van listando los abonos
				saldo_cuota = saldo_cuota - data[0].abonos[i].abono_monto;

		}

		//recorremos cada cuota de la venta
		//cuadratura de abonos
		for (var y = 0; y < data[0].cuotas.length; y++) {
				var cuadratura_cuota  = data[0].cuotas[y].cuota_num_cuota;//asignamos la primera cuota por defecto
				var cuadratura_abonos = 0;//variable para ir sumando los abonos para una cuota en particular
			//recorremos los abonos 
			for (var z = 0; z < data[0].abonos.length; z++) {
				if (data[0].abonos[z].abono_cuota == cuadratura_cuota) {
					cuadratura_abonos = cuadratura_abonos + data[0].abonos[z].abono_monto;
				}
			}
			if (cuadratura_abonos == 0) {
				//no existen abonos por ende queda en 0
				$('#tabla_cuadratura tbody').append('<tr><td>'+cuadratura_cuota+'</td><td>'+data[0].cuotas[y].cuota_debe+'</td><td>'+cuadratura_abonos+'</td><td> No existen Abonos</td></tr>');
			} else {
					if (cuadratura_abonos == data[0].cuotas[y].cuota_debe) {
						$('#tabla_cuadratura tbody').append('<tr><td>'+cuadratura_cuota+'</td><td>'+data[0].cuotas[y].cuota_debe+'</td><td>'+cuadratura_abonos+'</td><td>ok</td></tr>');
					} else {						
						if (cuadratura_abonos > data[0].cuotas[y].cuota_debe) {
							//diferencia = total abonos - monto cuota
							var cuadrtura_diferencia = cuadratura_abonos  - data[0].cuotas[y].cuota_debe;
						} else {
							//diferencia = total abonos - monto cuota
							var cuadrtura_diferencia =  data[0].cuotas[y].cuota_debe - cuadratura_abonos;
						}
						$('#tabla_cuadratura tbody').append('<tr><td>'+cuadratura_cuota+'</td><td>'+data[0].cuotas[y].cuota_debe+'</td><td>'+cuadratura_abonos+'</td><td> Descuadre - diferencia de '+cuadrtura_diferencia+'</td></tr>');
					}
			}
		}
		
		//ciclo for para listar los productos de la venta
		for (var p = 0; p < data[0].ventadetalles.length; p++) {
				var n = 1;
				var totalfinal = 0;
				var totalparcial = (data[0].ventadetalles[p].vd_cantidad * data[0].ventadetalles[p].vd_valor);
						totalfinal = totalfinal + totalparcial;
				$('#tabla_productos tbody').append('<tr><td>'+n+'</td><td>'+data[0].ventadetalles[p].productod_id+'</td><td>'+data[0].ventadetalles[p].vd_descripcion+'</td><td>'+data[0].ventadetalles[p].vd_cantidad+'</td><td>'+data[0].ventadetalles[p].vd_valor+'</td><td>'+totalparcial+'</td></tr>');
				n++;
		}
		//una vez listados todos los productos de la venta
		//se imprime el total final de la venta que es la suma de todo
		$('#tabla_productos tfoot').append('<tr><td colspan="5" class="text-right">Total: </td><td>'+totalfinal+'</td></tr>');



		//verificamos si hay devoluciones de productos
		//si es asi se lista
		if (data[0].devoluciones.length == 0) {
			$('#tabla_devoluciones tfoot').append('tr><td colspan="8"><h3 class="text-center text-danger">No existen Devoluciones</h3></td></tr>');
		} else {
			$('#tabla_devoluciones tfoot').append('<h3 class="text-center text-teal">existen Devoluciones</h3>');
		}





		//carga de datos de ventas
		$('#tabla_datos_ventas').append('<tr><td>Fecha Venta</td><td>'+formatofecha(data[0].venta_fecha)+'</td><td>Total Venta</td><td>'+data[0].venta_total+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>N° Cuotas</td><td>'+data[0].venta_num_cuota+'</td><td>Valor Cuota</td><td>'+data[0].venta_monto_cuota+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Primera Cuota</td><td>'+formatofecha(data[0].venta_fecha_primer_venc)+'</td><td>Ultima Revision</td><td>'+formatofecha(data[0].venta_fecha_revision)+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Forma de Pago</td><td>'+data[0].tipoformaspagos.tfp_descripcion+'</td><td>Estado Tarjeta</td><td>'+ data[0].ev_id +'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Descuentos</td><td>'+(data[0].descuentos.length!=0 ? data[0].descuentos[0].descuento_monto:0)+'</td><td>Fecha autorizacion</td><td>'+(data[0].descuentos.length!=0 ? (data[0].descuentos[0].descuento_fecha_autorizado!=null?formatofecha(data[0].descuentos[0].descuento_fecha_autorizado):'Por aprobar'):'Sin Descuento')+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Total Abonos</td><td>'+abonos+'</td><td>Devoluciones</td><td>Sin devoluciones</td></tr>');
		

		//validamos que el div box_mensaje_error no se este mostrando, de ser asi se oculta
		if ( $('.box_mensaje_error').css('display') =='block' ) {
			$('.box_mensaje_error').toggle(100);
		}
		//mostramos todos los box que se encuentran ocultos
		if ($('.box_datos, .box_datos_varios, .box_datos_venta').css('display') != 'block') {
			$('.box_datos, .box_datos_varios, .box_datos_venta').toggle(100);
		}

		}//fin del if de validacion de la data
	})
	.fail(function(data) {
		console.log("error, folio no se encuentra en el sistema");
	})
	.always(function(data) {
		console.log("complete");
	});
});

//limpiar formulario
$('#btn-reset-form').click(function(){
	location.href ='{{url("cobranza/revision_kardex")}}';
});

//imprimir tarjeta
$('#btn-imprimir-tarjeta').click(function(){
	var folio = $('#txtventa').val();
	var titulo= "Revision de Kardex folio N° "+folio;//titulo de la hoja

	var cliente          = document.getElementById('datos_cliente').innerHTML;//datos del cliente
	var abonos           = document.getElementById('abonos_unificados').innerHTML;
	var productos        = document.getElementById('productos').innerHTML;
	var venta            = document.getElementById('tabla_ventas').innerHTML;

	var myWindow = window.open('',titulo);//abrimos una nueva ventana

	myWindow.document.write('<html><head><title>'+titulo+'</title>');//agregamos las etiquetas html 
	myWindow.document.write('<link href="{{ asset("/css/all.css") }}" rel="stylesheet" type="text/css" media="all" />');//css
	myWindow.document.write('<style type="text/css">.hiddenRow {padding: 0 !important;}</style>');//css
	myWindow.document.write('</head><body >');
	myWindow.document.write(venta);
	myWindow.document.write(cliente);
	myWindow.document.write(productos);
	myWindow.document.write(abonos);
	
	myWindow.document.write('</body></html>');
	myWindow.document.close(); // necessary for IE >= 10
	myWindow.onload=function(){ // necessary if the div contain images
		myWindow.focus(); // necessary for IE >= 10
		myWindow.print();
		myWindow.close();
	}
});

//ver otros folios
//falta informacion para realizar esta funcionalidad

//grabar revision
$('#btn-grabar-revision').click(function(){
	{{--ahora enviamos el dato por ajax--}}
	$.ajax({
		beforeSend:function(){
		},
		url: '{{url("cobranza/revision_kardex/grabar_revision")}}',//ruta donde se enviara la informacion
		data: $('#form_revision_kardex').serialize(),//dato con la informacion
		type:'PUT',
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
                // options
                  title: '<strong>Listo!</strong>',
                  icon: 'fa fa-check',
                  message:'Revision Actualizada',
                },{
                // settings
                  type: 'success',
                });
		$('#fecha_revision').val("");
	})
	.fail(function(data) {
		console.log("error, folio no se encuentra en el sistema");
	})
	.always(function(data) {
		console.log("complete");
	});

});

</script>
@endsection
