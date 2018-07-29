{{--copie y pegue el siguiente codigo en cada una de sus paginas
	favor solo modifique la seccion de htmlheader_title en el apartado trans
	y la session main-content.
--}}
{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
{{--no modificar--}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
{{--para agregar el titulo de la pagina se debe agregar primero en el lang es ubicado en vendor/admin-lte-template-laravel/resources/lang/es/message.php  --}}
@section('htmlheader_title'){{ trans('adminlte_lang::message.revisionventas') }} @endsection

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
<div class="col-md-8"><i class="fa fa-file-text-o" aria-hidden="true"></i> Revision de Ventas</div>
<div class="col-md-4">
	<div class="col-md-12">
		<div class="input-group">
	    	<input type="text" class="form-control" placeholder="Folio..." id="txtfoliobuscar" tabindex="1">
	    	<span class="input-group-btn">
	    		<button class="btn btn-secondary btn-info" id="buscar_folio" type="button" tabindex="2" >Buscar</button>
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
		  <div class="box box-info box_datos" id="tabla_cliente" style="display: none;">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-inbox"></i> Datos</h3>
		      <div class="box-tools pull-right">
		        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
		        </button>
		      </div>
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body">
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
								
								</div>
		            		</div>
				        </div>
			        </div>
		        </div>

		        <div class="col-md-9">
		        	<div class="col-md-12">
	            	<div class="col-md-6 col-lg-4 col-sm-12">
	            		<p><i class="fa fa-map-marker"></i> Direccion</p>
	            		<p id="perfil_direccion"></p>
	            	</div>
	            	<div class="col-md-6 col-lg-4 col-sm-12">
	            		<p><i class="fa fa-globe"></i> Ciudad</p>
	            		<p id="perfil_ciudad"></p>
	            	</div>
	            	<div class="col-md-6 col-lg-4 col-sm-12">
	            		<p><i class="fa fa-compass"></i> Barrio</p>
	            		<p id="perfil_barrio"></p>
	            	</div>
	            	<div class="col-md-6 col-lg-4 col-sm-12">
	            		<p><i class="fa fa-location-arrow"></i> Localidad</p>
	            		<p id="perfil_localidad"></p>
	            	</div>
	            	<div class="col-md-6 col-lg-4 col-sm-12">
	            		<p><i class="fa fa-mobile"></i> Telefono</p>
	            		<p id="perfil_telefono"></p>
	            	</div>
	            	<div class="col-md-6 col-lg-4 col-sm-12">
	            		<p><i class="fa fa-money"></i> Cupo</p>
	            		<p id="perfil_cupo"></p>
	            	</div>
		        	</div>
		        	<div class="col-md-12">
		        		<hr style="border: 1px solid;opacity: 0.3;">
		        	</div>
		        	<div class="col-md-12">
		        		
		        	</div>
		        </div>
		        <!-- /.col -->
		      </div>
		      <!-- /.row --> 
		    </div>
		    <!-- ./box-body -->
		    <div class="box-footer hidden-print">
		      <div class="row">
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block border-right">
		            <a class="btn btn-app"  id="btn-reset-form">
		              <i class="fa fa-refresh"></i> Nueva Revision
		            </a>
		          </div>
		          <!-- /.description-block -->
		        </div>
		        <!-- /.col -->
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block border-right">
		            <a class="btn btn-app" onclick="imprimirTarjeta()">
		              <i class="fa fa-print"></i> Imprimir Tarjeta
		            </a>
		          </div>
		          <!-- /.description-block -->
		        </div>
		        <!-- /.col -->
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block border-right">
		            <a class="btn btn-app" disabled>
		              <i class="fa fa-print"></i> Imprimir Ficha
		            </a>
		            
		          </div>
		          <!-- /.description-block -->
		        </div>
		        <!-- /.col -->
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block">
		            <a class="btn btn-app" id="guardar_descuento" disabled>
		              <i class="fa fa-floppy-o"></i> Guardar
		            </a>
		            
		          </div>
		          <!-- /.description-block -->
		        </div>
		      </div>
		      <!-- /.row -->
		    </div>
		    <!-- /.box-footer -->
		  </div>
		  <!-- /.box -->
		</div>
		<!-- /.col -->
	</div>

	{{-- seccion para ver la informacion de la venta  --}}
	<div class="row box_datos_venta" style="display: none;">
		<div class="col-md-12" id="tabla_ventas">
			<div class="box box-danger">
	          <div class="box-header with-border">
	            <h3 class="box-title"><i class="fa fa-th-list"></i> Datos Venta</h3>
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
	{{--listamos las cuotas--}}
	<div class="row box_datos_cuotas" style="display: none;">
		<div class="col-md-12" id="tabla_cuotas">
			<div class="box box-info">
	          <div class="box-header with-border">
	            <h3 class="box-title"><i class="fa fa-th-list"></i> Cuotas de la Venta</h3>
	            <div class="box-tools pull-right">
	              <button type="button" class="btn btn-box-tool hidden-print" data-widget="collapse"><i class="fa fa-minus"></i></button>
	            </div>
	          </div>
	          <!-- /.box-header -->
	          <div class="box-body">
				<div class="table-responsive">
					<table class="table" id="tabla_cuotas_venta">
						<thead>
							<tr>
								<th>N°</th>
								<th>Fecha Vencimiento</th>
								<th>Monto</th>
								<th>Debe</th>
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
	            <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('tabla_cuotas')">
	      			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
	    			</a>
	          </div>
	          <!-- /.box-footer -->
	        </div>
		</div>
	</div>
	
	{{--datos de los abonos--}}
	<div class="row box_datos_abonos" style="display: none;">
		<div class="col-md-12" id="tabla_abonos">
			<div class="box box-warning">
	          <div class="box-header with-border">
	            <h3 class="box-title"><i class="fa fa-th-list"></i> Abonos de la Venta</h3>
	            <div class="box-tools pull-right">
	              <button type="button" class="btn btn-box-tool hidden-print" data-widget="collapse"><i class="fa fa-minus"></i></button>
	            </div>
	          </div>
	          <!-- /.box-header -->
	          <div class="box-body">
				<div class="table-responsive">
					<table class="table" id="tabla_abonos_venta">
						<thead>
							<tr>
								<th>N°</th>
								<th>Fecha Abono</th>
								<th>Monto</th>
								<th>N° Cuota</th>
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
	            <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('tabla_abonos')">
	      			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
	    			</a>
	          </div>
	          <!-- /.box-footer -->
	        </div>
		</div>
	</div>

	{{--datos de los productos--}}
	<div class="row box_datos_productos" style="display: none;">
		<div class="col-md-12" id="tabla_productos">
			<div class="box box-danger">
	          <div class="box-header with-border">
	            <h3 class="box-title"><i class="fa fa-th-list"></i> Productos de la Venta</h3>
	            <div class="box-tools pull-right">
	              <button type="button" class="btn btn-box-tool hidden-print" data-widget="collapse"><i class="fa fa-minus"></i></button>
	            </div>
	          </div>
	          <!-- /.box-header -->
	          <div class="box-body">
				<div class="table-responsive">
					<table class="table" id="tabla_productos_venta">
						<thead>
							<tr>
								<td>Item</td>
								<td>Codigo</td>
								<td>Descripcion</td>
								<td>Cantidad</td>
								<td>Precio</td>
								<td>Total</td>
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
	            <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('tabla_productos')">
	      			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
	    			</a>
	          </div>
	          <!-- /.box-footer -->
	        </div>
		</div>
	</div>

	{{--datos de las devoluciones--}}
	<div class="row box_datos_devoluciones" style="display: none;">
		<div class="col-md-12" id="tabla_devoluciones">
			<div class="box box-success">
	          <div class="box-header with-border">
	            <h3 class="box-title"><i class="fa fa-th-list"></i> Devoluciones de la Venta</h3>
	            <div class="box-tools pull-right">
	              <button type="button" class="btn btn-box-tool hidden-print" data-widget="collapse"><i class="fa fa-minus"></i></button>
	            </div>
	          </div>
	          <!-- /.box-header -->
	          <div class="box-body">
				<div class="table-responsive">
					<table class="table" id="tabla_devoluciones_venta">
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
					</table>
				</div>
	            <!-- /.table-responsive -->
	          </div>
	          <!-- /.box-body -->
	          <div class="box-footer clearfix">
	            <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('tabla_devoluciones')">
	      			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
	    			</a>
	          </div>
	          <!-- /.box-footer -->
	        </div>
		</div>
	</div>

	{{--datos de otras venta del cliente    aun falta informacion para completar esto--}}
	<div class="row box_datos_otros_folios" style="display: none;">
		<div class="col-md-12" id="tabla_folios">
			<div class="box box-info">
	          <div class="box-header with-border">
	            <h3 class="box-title"><i class="fa fa-th-list"></i> Otros Folios del Cliente</h3>
	            <div class="box-tools pull-right">
	              <button type="button" class="btn btn-box-tool hidden-print" data-widget="collapse"><i class="fa fa-minus"></i></button>
	            </div>
	          </div>
	          <!-- /.box-header -->
	          <div class="box-body">
				<div class="table-responsive">
					<table class="table" id="tabla_otros_folios">
						<tbody>
						</tbody>
					</table>
				</div>
	            <!-- /.table-responsive -->
	          </div>
	          <!-- /.box-body -->
	          <div class="box-footer clearfix">
	            <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('tabla_folios')">
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
<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript">
//funcion para imprimir usando window.print()
function imprimirTarjeta(){
	//obtenemos los divs que se incluiran
	var venta        =document.getElementById('tabla_ventas').innerHTML;
	var abonos       =document.getElementById('tabla_abonos').innerHTML;
	var cuotas       =document.getElementById('tabla_cuotas').innerHTML;
	var productos    =document.getElementById('tabla_productos').innerHTML;
	var devoluciones =document.getElementById('tabla_devoluciones').innerHTML;
	var cliente      =document.getElementById('tabla_cliente').innerHTML;

	var titulo= $('#informe .box-title').text();
	var myWindow = window.open('',titulo);//abrimos una nueva ventana, el nombre del archivo sera my div
	myWindow.document.write('<html><head><title>'+titulo+'</title>');//agregamos las etiquetas html 
	myWindow.document.write('<link href="{{ asset("/css/all.css") }}" rel="stylesheet" type="text/css" media="all" />');
	myWindow.document.write('<style type="text/css">.hiddenRow {padding: 0 !important;}</style>');
	myWindow.document.write('</head><body >');
	myWindow.document.write(cliente);
	myWindow.document.write(venta);
	myWindow.document.write(cuotas);
	myWindow.document.write(abonos);
	myWindow.document.write(productos);
	myWindow.document.write(devoluciones);
	myWindow.document.write('</body></html>');
	myWindow.document.close(); // necessary for IE >= 10
	myWindow.onload=function(){ // necessary if the div contain images
		myWindow.focus(); // necessary for IE >= 10
		myWindow.print();
		myWindow.close();
	};
}//fin funcion imprselect




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
			if ( $('.box_datos, .nav_datos_venta, .box_datos_venta, .box_datos_cuotas, .box_datos_abonos, .box_datos_productos, .box_datos_devoluciones').css('display')=='block' ) {
				$('.box_datos, .nav_datos_venta, .box_datos_venta, .box_datos_cuotas, .box_datos_abonos, .box_datos_productos, .box_datos_devoluciones').toggle(100);
			}
			//si el div box_mensaje_error esta oculto lo muestra
			if ($('.box_mensaje_error').css('display') != 'block') {
				$('.box_mensaje_error').toggle(100);
			}

		} else {


			{{--comenzamos a llenar los campos con datos
				creamos variables para ser utilizadas mas tarde--}}
			var abonos = 0;
			var saldo  = 0;
			{{--sumamos todos los abonos--}}
			for (var i = 0; i < data[0].abonos.length; i++) {
				abonos = abonos + data[0].abonos[i].abono_monto;
			}
			{{-- calculamos el saldo pendiente restando el total de la venta - el total de abonos --}}
			saldo = data[0].venta_total - abonos;
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
				//desactivamos todos los input para bloquear que se ingrese un descuento ya que la venta esta finalizada
				$('#form_aplicar_descuento :input').attr('disabled',true);
			}
		//asignamos el maximo de descuento al input 
		$('#txtmontodescuento').attr('max',saldo);
		//mostramos un mensaje con el maximo permitido, es el mismo que se asigna al input
		$('#helpBlock').html('maximo descuento permitido '+saldo);
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
			$('#perfil_telefono').html('No Disponible');
		} else {
			$('#perfil_telefono').html(''+data[0].clientes.cliente_fono+'');
		}
		if (data[0].clientes.cliente_linea_credito =="") {
			$('#perfil_cupo').html('No Disponible');
		} else {
			$('#perfil_cupo').html(''+data[0].clientes.cliente_linea_credito+'');
		}
		if (data[0].clientes.cliente_bloqueado =="") {
			$('#perfil_bloqueado').html('No Disponible');
		} else {
			if(data[0].clientes.cliente_bloqueado == 1){
				$('#perfil_bloqueado').html('No');
			}else{
				$('#perfil_bloqueado').html('Si');
			}
		}
		if (data[0].clientes.created_at == "") {
			$('#perfil_creado_desde').html('No Disponible');
		} else {
			var fecha_creacion = formatofecha(data[0].clientes.created_at);
			$('#perfil_creado_desde').html(''+fecha_creacion+'');
		}
		
		$('#txtventa').val(data[0].venta_id);

		//carga de datos de ventas
		$('#tabla_datos_ventas').append('<tr><td>Fecha Venta</td><td>'+formatofecha(data[0].venta_fecha)+'</td><td>Total Venta</td><td>'+data[0].venta_total+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>N° Cuotas</td><td>'+data[0].venta_num_cuota+'</td><td>Valor Cuota</td><td>'+data[0].venta_monto_cuota+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Primera Cuota</td><td>'+formatofecha(data[0].venta_fecha_primer_venc)+'</td><td>Ultima Revision</td><td>'+formatofecha(data[0].venta_fecha_revision)+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Forma de Pago</td><td>'+data[0].tipoformaspagos.tfp_descripcion+'</td><td>Estado Tarjeta</td><td>'+ data[0].ev_id +'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Descuentos</td><td>'+(data[0].descuentos.length!=0 ? data[0].descuentos[0].descuento_monto:0)+'</td><td>Fecha autorizacion</td><td>'+(data[0].descuentos.length!=0 ? (data[0].descuentos[0].descuento_fecha_autorizado!=null?formatofecha(data[0].descuentos[0].descuento_fecha_autorizado):'Por aprobar'):'Sin Descuento')+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Total Abonos</td><td>'+abonos+'</td><td>Devoluciones</td><td>Sin devoluciones</td></tr>');
		

		//datos cuotas
		for (var i = 0; i < data[0].cuotas.length; i++) {
			$('#tabla_cuotas_venta tbody').append('<tr><td>'+data[0].cuotas[i].cuota_num_cuota+'</td><td>'+data[0].cuotas[i].cuota_fecha_venc+'</td><td>'+data[0].cuotas[i].cuota_debe+'</td><td>'+data[0].cuotas[i].cuota_haber+'</td></tr>');
		}

		//datos abonos
		for (var i = 0; i < data[0].abonos.length; i++) {
			$('#tabla_abonos_venta tbody').append('<tr><td>'+ (i + 1) +'</td><td>'+data[0].abonos[i].abono_fecha_pago+'</td><td>'+data[0].abonos[i].abono_monto+'</td><td>'+data[0].abonos[i].abono_cuota+'</td></tr>');

		}

		//datos productos
		for (var i = 0; i < data[0].ventadetalles.length; i++) {
			var n = 1;
			var totalfinal = 0;
			var totalparcial = (data[0].ventadetalles[i].vd_cantidad * data[0].ventadetalles[i].vd_valor);
				totalfinal = totalfinal + totalparcial;
			$('#tabla_productos_venta tbody').append('<tr><td>'+n+'</td><td>'+data[0].ventadetalles[i].productod_id+'</td><td>'+data[0].ventadetalles[i].vd_descripcion+'</td><td>'+data[0].ventadetalles[i].vd_cantidad+'</td><td>'+data[0].ventadetalles[i].vd_valor+'</td><td>'+totalparcial+'</td></tr>');
			n++;
		}

		//datos devoluciones
		//verificamos si hay devoluciones de productos
		//si es asi se lista
		

		//falta informacion para continuar con esto
		if (data[0].devoluciones.length == 0) {
			$('#tabla_devoluciones_venta tbody').append('tr><td colspan="8"><h3 class="text-center text-danger">No existen Devoluciones</h3></td></tr>');
		} else {
			$('#tabla_devoluciones_venta tbody').append('<h3 class="text-center text-teal">existen Devoluciones</h3>');
		}







		//validamos que el div box_mensaje_error no se este mostrando, de ser asi se oculta
		if ( $('.box_mensaje_error').css('display') =='block' ) {
			$('.box_mensaje_error').toggle(100);
		}
		//mostramos todos los box que se encuentran ocultos
		if ($('.box_datos, .nav_datos_venta, .box_datos_venta, .box_datos_cuotas, .box_datos_abonos, .box_datos_productos, .box_datos_devoluciones').css('display') != 'block') {
			$('.box_datos, .nav_datos_venta, .box_datos_venta, .box_datos_cuotas, .box_datos_abonos, .box_datos_productos, .box_datos_devoluciones').toggle(100);
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

</script>
@endsection