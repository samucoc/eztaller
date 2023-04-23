{{--copie y pegue el siguiente codigo en cada una de sus paginas
	favor solo modifique la seccion de htmlheader_title en el apartado trans
	y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.Ingresocobranza') }}
@endsection


{{--aqui escribe tu css--}}
@section('mi-css')
<style type="text/css">
	[contenteditable="true"]{
		border: 1px dotted transparent;
		background: #fff7c3;
	}
</style>
@endsection

{{--aqui escribe el titulo de la pagina la cual se vera dentro del contenido--}}
@section('contentheader_title')
<div class="col-md-8"><i class="fa fa-file-text-o" aria-hidden="true"></i> Ingreso de Cobranza</div>
<div class="col-md-4">
	<div class="col-md-12">
		<div class="input-group">
	    	<input type="number" class="form-control" placeholder="Folio..." id="txtfoliobuscar" tabindex="1"  onkeypress="">
	    	<span class="input-group-btn">
	    		<button class="btn btn-secondary btn-info" id="buscar_folio" type="button" tabindex="2">Buscar</button>
	      	</span>
	    </div>
	</div>
</div>
@endsection

{{--aqui escribe la descripcion de la pagina, esta ira junto con el titulo de la seccion anterior--}}
@section('contentheader_description')
@endsection

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

	{{-- seccion para los datos del cliente y el ingreso de abonos  --}}
	<div class="row">
		{{-- Datos del cliente --}}
		<div class="col-md-4">
			<div class="box box-success box_profile" style="display: none;">
	            <div class="box-body" id="perfil">
					<h3 class="profile-username text-center text-uppercase" id="perfil_nombre"></h3>
					<p class="text-muted text-center" id="perfil_rut"></p>
					<p class="text-muted text-center" id="perfil_estado"></p>
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item" id="perfil_direccion"></li>
						<li class="list-group-item" id="perfil_ciudad"></li>
						<li class="list-group-item" id="perfil_barrio"></li>
						<li class="list-group-item" id="perfil_localidad"></li>
					</ul>
	            </div>
	            <div class="box-footer">
	            	<a class="btn btn-app hidden-print" href="javascript:imprSelec('table-general')">
                		<i class="fa fa-print" aria-hidden="true"></i> Imprimir
              		</a>
	            </div>
        	</div>
		</div>

		{{-- Ingreso Abono --}}
		<div class="col-md-8 hidden-print">
			<div class="table-responsive box box-info box_abonos" style="display: none;" >
				<form action="{{url('cobranza/ingreso_cobranza/abono')}}" method="POST" id="form_ingreso_abono">
				<table class="table table-hover">
					<thead>
						<tr>
							<th colspan="3" class="text-uppercase">Ingreso de Abono</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Sector:</td>
							<td id="abono_sector"></td>
						</tr>
						<tr>
							<td>cobrador:</td>
							<td>
								<input type="hidden" name="_method" value="PUT">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<input type="hidden" name="txtventa" value="" id="txtventa" />
								<input type="hidden" name="txttotal" value="txttotal" id="txttotal" />
								<input type="hidden" name="txtcuotas" value="txtcuotas" id="txtcuotas" />
								<input type="text" name="txtcobrador" class="form-control busquedacobrador" id="abono_cobrador" tabIndex="3">
							</td>
							<td></td>
						</tr>
						<tr>
							<td>Supervisor:</td>
							<td><input type="text" name="txtsupervisor" value="" class="form-control busquedasupervisor" id="abono_supervisor" tabIndex="4"></td>
							<td></td>
						</tr>
						<tr>
							<td>Tipo de Abono:</td>
							<td>
								<select name="txttipoabono" id="" class="form-control" required="required" tabIndex="5">
									<option value="0">Seleccione</option>
									@foreach($tipoabonos as $tipoabono)
										<option value="{{$tipoabono->ta_id}}">{{$tipoabono->ta_descripcion}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<td>Fecha Pago:</td>
							<td><input type="text" name="txtfecha" value="" class="form-control fecha_tope" id="fecha_pago" tabIndex="6" ></td>
						</tr>
						<tr>
							<td>Monto:</td>
							<td><input type="number" name="txtmonto" value="" class="form-control" id="form-abono" tabIndex="7"></td>
							<td id="form_saldo"></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td>						
								<button type="submit" class="btn btn-info btn-flat pull-right" id="guardar_abono"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
							</td>
						</tr>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
				</form>
			</div>
		</div>
	</div>

	{{-- seccion para ver los abonos hechos por el cliente  --}}
	<div class="row tabla_misabonos" style="display: none;">
		<div class="col-md-12" id="table-misabonos">
			<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title text-uppercase">Mis Abonos</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool hidden-print" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


				{{--tabla abonos unificados--}}
				<div class="table-responsive">
					<table class="table no-margin" id="tabla_abonos_unificados">
					<legend class="text-center">Abonos unificados</legend>
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
				<br><br>
				{{--tabla abonos desglosados--}}
				<div class="table-responsive">
					<table class="table no-margin" id="tabla_abonos">
					<legend class="text-center">Desglose de abonos</legend>
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
								<th class="hidden-print">Acciones</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
            	<a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('table-misabonos')">
        			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
      			</a>
            </div>
            <!-- /.box-footer -->
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
			if ( $('.box_profile, .box_abonos, .box_datos_venta, .tabla_misabonos').css('display')=='block' ) {
				$('.box_profile, .box_abonos, .box_datos_venta, .tabla_misabonos').toggle(100);
			}
			//si el div box_mensaje_error esta oculto lo muestra
			if ($('.box_mensaje_error').css('display') != 'block') {
				$('.box_mensaje_error').toggle(100);
			}

		} else {
			//verificamos el estado de la venta 2 para pagada y 3 para cancelada
			if(data[0].ev_id ==2){
				$.notify({
					// options
					title: '<strong>Venta Finalizada</strong>',
					icon: 'fa fa-check-circle-o fa-2x',
					message: 'La venta a sido pagada',
				},{
					// settings
					type: 'success'
				});
				return false;
			}else{
				if(data[0].ev_id ==3){
					$.notify({
						// options
						title: '<strong>Venta Cancelada</strong>',
						icon: 'fa fa-check-circle-o fa-2x',
						message: 'La venta fue cancelada ',
					},{
						// settings
						type: 'warning'
					});
					return false;
				}	
			}

			var abonos = 0;
			var saldo  = 0;
			for (var i = 0; i < data[0].abonos.length; i++) {
				abonos = abonos + data[0].abonos[i].abono_monto;
			}

			if(data[0].descuentos.length != 0){
				if(data[0].descuentos[0].descuento_autorizado == 1){
					{{-- calculamos el saldo pendiente restando el total de la venta - el total de abonos - descuentos --}}
					saldo = data[0].venta_total - abonos - data[0].descuentos[0].descuento_monto;
					abonos= abonos + data[0].descuentos[0].descuento_monto;
				}else{
					{{-- calculamos el saldo pendiente restando el total de la venta - el total de abonos --}}
					saldo = data[0].venta_total - abonos;
				}
			}else{
					{{-- calculamos el saldo pendiente restando el total de la venta - el total de abonos --}}
					saldo = data[0].venta_total - abonos;
			}

			//verificamos si los abonos son iguales al la venta total
			//si es 'si' quiere decir que la venta esta cancelada
			//pasamos a mostrar un mensaje señalando que la venta ya se encuentra cancelada
			if (abonos == data[0].venta_total) {
				$.notify({
					// options
					title: '<strong>Venta Cancelada</strong>',
					icon: 'fa fa-check-circle-o fa-2x',
					message: 'La venta no presenta saldos pendiente',
				},{
					// settings
					type: 'success'
				});
				$('#form_saldo').html("Saldo Pendiente: "+saldo);
				$('.box_abonos :input').attr("disabled",true);
			} else {
				$('#form_saldo').html("Saldo Pendiente: "+saldo);
				$('#form-abono').attr('max',saldo);
				if(saldo == data[0].venta_total){
					$('#tabla_abonos tbody').append('<tr><td colspan="10"><h2 class="text-center text-danger">No existen abonos</h2></td></tr>');
				}
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
			$('#perfil_direccion').html('<b><i class="fa fa-map-marker" aria-hidden="true"></i> Direccion</b><a class="pull-right">No Disponible</a>');
		} else {
			$('#perfil_direccion').html('<b><i class="fa fa-map-marker" aria-hidden="true"></i> Direccion</b><a class="pull-right">'+data[0].clientes.cliente_direccion+'</a>');
		}
		if (data[0].clientes.cliente_ciudad =="") {
			$('#perfil_ciudad').html('<b><i class="fa fa-globe" aria-hidden="true"></i> Ciudad</b><a class="pull-right">No Disponible</a>');
		} else {
			$('#perfil_ciudad').html('<b><i class="fa fa-globe" aria-hidden="true"></i> ciudad</b> <a class="pull-right">'+data[0].clientes.cliente_ciudad+'</a>');
		}
		if (data[0].clientes.cliente_barrio =="") {
			$('#perfil_barrio').html('<b><i class="fa fa-compass" aria-hidden="true"></i> Barrio</b><a class="pull-right">No Disponible</a>');
		} else {
			$('#perfil_barrio').html('<b><i class="fa fa-compass" aria-hidden="true"></i> Barrio</b> <a class="pull-right">'+data[0].clientes.cliente_barrio+'</a>');
		}
		if (data[0].clientes.cliente_localidad =="") {
			$('#perfil_localidad').html('<b><i class="fa fa-location-arrow" aria-hidden="true"></i> Localidad</b><a class="pull-right">No Disponible</a>');
		} else {
			$('#perfil_localidad').html('<b><i class="fa fa-location-arrow" aria-hidden="true"></i> Localidad</b> <a class="pull-right">'+data[0].clientes.cliente_localidad+'</a>');
		}

		//carga de datos de ingreso de abono
		$('#abono_sector').html(data[0].sectores.sector_codigo+' - '+data[0].sectores.sector_descripcion);

		//vaidamos que el/los abonos tenga cobrador
		if (data[0].abonos != ''){
			$('#abono_cobrador').val(data[0].abonos[data[0].abonos.length-1].cobrador.trabajador_id+' - '+data[0].abonos[data[0].abonos.length-1].cobrador.trabajador_nombres);
			$('#abono_supervisor').val(data[0].abonos[data[0].abonos.length-1].supervisor.trabajador_id+' - '+data[0].abonos[data[0].abonos.length-1].supervisor.trabajador_nombres);
		}else{
			$('#abono_cobrador').attr('placeholder','Sin cobrador asignado');
			$('#abono_cobrador').removeAttr("disabled");
			$('#abono_supervisor').attr('placeholder','Sin supervisor asignado');
			$('#abono_cobrador').removeAttr("disabled");
		}
		
		{{-- cargamos estos datos en input con attr hidden para poder enviarlo junto al formulario --}}
		//$('#form-abono').val(data[0].venta_monto_cuota);
		$('#txtventa').val(data[0].venta_id);
		$('#txttotal').val(data[0].venta_total);
		$('#txtcuotas').val(data[0].venta_num_cuota);

		//carga de datos de mis abonos
		var saldo_venta = data[0].venta_total;
		var saldo_cuota = 0;
		var dias        = 0;
		var dia_ini     = 0;
		var dia_fin     = 0;
		var dias_atraso = 0;
		var hoy = new Date();
		var dia = (hoy.getDate()<10)? '0'+hoy.getDate():hoy.getDate();
		var mes = ((hoy.getMonth()+1)<10)?'0'+(hoy.getMonth()+1):(hoy.getMonth()+1);
		hoy = hoy.getFullYear()+'-'+mes+'-'+dia;
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

			//obtenemos laa fecha de ingreso del abono
			var fecha_ingreso = new Date(data[0].abonos[i].created_at);
			//obtenemos el dia
			var d= (fecha_ingreso.getDate()<10)?'0'+fecha_ingreso.getDate():fecha_ingreso.getDate();
			//obtenemos el mes
			var m= ((fecha_ingreso.getMonth()+1)<10)?'0'+(fecha_ingreso.getMonth()+1):(fecha_ingreso.getMonth()+1);
			//por ultimo concadenamos todas las variables
			fecha_ingreso = fecha_ingreso.getFullYear()+'-'+m+'-'+d;
			//comparamos la fecha de ingreso del abono con la fecha de hoy
			//asi habilitar la edicion del abono que haya sido ingresado el mismo dia
			if (fecha_ingreso == hoy ) {
				//procedemos a listar todos los abonos
			$('#tabla_abonos tbody').append('<tr><td>'+ (i+1)+'<input type="hidden" name="_token" value="{{ csrf_token() }}"></input></td><td id="fecha'+i+'">'+formatofecha(data[0].abonos[i].abono_fecha_pago)+'</td><td id="abono'+i+'">'+data[0].abonos[i].abono_monto+'</td><td>'+saldo_venta+'</td><td>'+data[0].abonos[i].abono_cuota+'</td><td>'+formatofecha(data[0].abonos[i].abono_fecha_venc)+'</td><td>'+data[0].cuotas[data[0].abonos[i].abono_cuota -1].cuota_debe+'</td><td>'+(saldo_cuota - data[0].abonos[i].abono_monto)+'</td><td>'+ dias_atraso +'</td><td class="hidden-print"><a class="btn btn-flat btn-warning" id="eliminar_abono'+i+'" onClick="eliminarAbono('+i+');" vt="'+data[0].venta_id+'" cr="'+data[0].abonos[i].abono_correlativo+'" name="'+data[0].abonos[i].abono_id+'"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a></td></tr>');
			} else {
				//procedemos a listar todos los abonos
				$('#tabla_abonos tbody').append('<tr><td>'+ (i+1) +'</td><td>'+formatofecha(data[0].abonos[i].abono_fecha_pago)+'</td><td>'+data[0].abonos[i].abono_monto+'</td><td>'+saldo_venta+'</td><td>'+data[0].abonos[i].abono_cuota+'</td><td>'+formatofecha(data[0].abonos[i].abono_fecha_venc)+'</td><td>'+data[0].cuotas[data[0].abonos[i].abono_cuota -1].cuota_debe+'</td><td>'+(saldo_cuota - data[0].abonos[i].abono_monto)+'</td><td>'+ dias_atraso +'</td><td></td></tr>');
			}
			//vamos disminuyendo el saldo de cada cuota a medida se van listando los abonos
			saldo_cuota = saldo_cuota - data[0].abonos[i].abono_monto;
		}
			
		//carga de datos de ventas
		$('#tabla_datos_ventas').append('<tr><td>Fecha Venta</td><td>'+formatofecha(data[0].venta_fecha)+'</td><td>Total Venta</td><td>'+data[0].venta_total+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>N° Cuotas</td><td>'+data[0].venta_num_cuota+'</td><td>Valor Cuota</td><td>'+data[0].venta_monto_cuota+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Primera Cuota</td><td>'+formatofecha(data[0].venta_fecha_primer_venc)+'</td><td>Ultima Revision</td><td>'+data[0].venta_fecha_revision+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Forma de Pago</td><td>'+data[0].tipoformaspagos.tfp_descripcion+'</td><td>Estado Tarjeta</td><td>'+ data[0].ev_id +'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Descuentos</td><td>'+(data[0].descuentos.length!=0 ? data[0].descuentos[0].descuento_monto:0)+'</td><td>Fecha autorizacion</td><td>'+(data[0].descuentos.length!=0 ? (data[0].descuentos[0].descuento_fecha_autorizado!=null?formatofecha(data[0].descuentos[0].descuento_fecha_autorizado):'Por aprobar'):'Sin Descuento')+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Total Abonos</td><td>'+abonos+'</td><td>Devoluciones</td><td>Sin devoluciones</td></tr>');
		
		//validamos que el div box_mensaje_error no se este mostrando, de ser asi se oculta
		if ( $('.box_mensaje_error').css('display') =='block' ) {
			$('.box_mensaje_error').toggle(100);
		}

		//mostramos todos los box que se encuentran ocultos
		if ($('.box_profile, .box_abonos, .box_datos_venta, .tabla_misabonos').css('display') != 'block') {
			$('.box_profile, .box_abonos, .box_datos_venta, .tabla_misabonos').toggle(100);
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

//funcion para ingresar el abono
$('#form_ingreso_abono').submit(function(e) {
	//evitamos que el formulario se envie
	e.preventDefault();
	var url = $(this).attr('action');
	$.ajax({
		url: url,//ruta donde se enviara la informacion
		type:"PUT",
		data: $(this).serialize(),//dato con la informacion
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
		//mostramos un mensaje en patalla para que el usuario sepa que el abono fue ingresado
		$.notify({
			// options
			title: '<strong>Listo!</strong>',
			icon: 'fa fa-check-circle-o',
			message: 'El Abono fue ingresado correctamente',
		},{
			// settings
			type: 'success'
		});

		$("#fecha_pago, #form-abono").val("");
	})
	.fail(function(data) {
		console.log("error");
		$.notify({
			// options
			title: '<strong>Upps!</strong>',
			icon: 'fa fa-exclamation-circle',
			message: 'El Abono es mayor a el saldo pendiente o hubo problemas al tratar de ingresar el abono',
		},{
			// settings
			type: 'danger'
		});
	})
	.always(function(data) {
		console.log("complete");
	});
})

function eliminarAbono(num){
	var elemento = document.getElementById('eliminar_abono'+num);
	
	var abono = $(elemento).attr('name');//abono id
	var venta = $(elemento).attr('vt');//venta id
	var correlativo = $(elemento).attr('cr');
	var tk = $('input[type="hidden"]').val();//token laravel
	$.ajax({
		url: '{{url("cobranza/ingreso_cobranza/eliminar_abono")}}',//ruta donde se enviara la informacion
		type:"PUT",
		data: {abono:abono,venta:venta,correlativo:correlativo,_token:tk},//datos con la informacion 
	})
	.done(function(data){
		console.log("success");
		if (data == 1) {
			$.notify({
				// options
				title: '<strong>Listo!</strong>',
				icon: 'fa fa-check-circle-o',
				message: 'El Abono fue eliminado con exito, Actualice la pagina para ver los cambios',
			},{
				// settings
				type: 'success'
			});
		}else{
			if (data == 2 ) {
				$.notify({
					// options
					title: '<strong>Oooops!</strong>',
					icon: 'fa fa-exclamation-circle',
					message: 'El Abono no pudo ser eliminado',
				},{
					// settings
					type: 'danger'
				});
			}
		}
	})
	.fail(function(data) {
		console.log("error");
		if (data == 2) {
			$.notify({
				// options
				title: '<strong>Oooops!</strong>',
				icon: 'fa fa-exclamation-circle',
				message: 'El Abono no pudo ser eliminado',
			},{
				// settings
				type: 'danger'
			});
		}
	})
	.always(function(data) {
		console.log("complete");
	});
}

</script>
@endsection