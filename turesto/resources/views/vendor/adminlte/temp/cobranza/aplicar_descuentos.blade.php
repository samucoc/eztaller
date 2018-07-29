{{--copie y pegue el siguiente codigo en cada una de sus paginas
	favor solo modifique la seccion de htmlheader_title en el apartado trans
	y la session main-content.
--}}
{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
{{--no modificar--}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
{{--para agregar el titulo de la pagina se debe agregar primero en el lang es ubicado en vendor/admin-lte-template-laravel/resources/lang/es/message.php  --}}
@section('htmlheader_title'){{ trans('adminlte_lang::message.aplicardescuentos') }} @endsection

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
<div class="col-md-8"><i class="fa fa-file-text-o" aria-hidden="true"></i> Aplicacion de Descuentos</div>
<div class="col-md-4">
	<div class="col-md-12">
		<div class="input-group">
	    	<input type="text" class="form-control" placeholder="Folio..." id="txtfoliobuscar" autofocus>
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
		  <div class="box box-info box_datos" style="display: none;">
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
				        <div class="">
					        <h3 class="text-center" id="perfil_nombre">Nadia Carmichael</h3>
					        <h5 class="text-center" id="perfil_rut">99.999.999-9</h5>
					        <p class="text-muted text-center" id="perfil_estado"></p>
				        </div>
				        <br>
				        <div class="col-md-12 col-lg-12 col-sm-12">
				        	<p class="text-center"><i class="fa fa-user-plus"></i> Miembro desde</p>
	            		<p class="text-center" id="perfil_creado_desde"></p>
            		</div>
								<div class="col-md-12 col-lg-12 col-sm-12">
            			<p class="text-center"><i class="fa fa-lock"></i> Bloqueado</p>
            			<p class="text-center" id="perfil_bloqueado"></p>
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
		        		<p class="text-left" ><strong>Aplicar Descuento</strong></p>
		        		<div>
			        		<form action="" method="POST" class="form-horizontal" role="form" id="form_aplicar_descuento">
		        				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<input type="hidden" name="txtventa" value="" id="txtventa" />
								<input type="hidden" name="txtsector" value="" id="txtsector" />
		        				<div class="form-group">
		        					<div class="col-sm-2">
		        						Fecha del Descuento
		        					</div>
		        					<div class="col-sm-10">
		        						<input type="text" name="txtfechadescuento" class="form-control fecha_tope">
		        					</div>
		        				</div>
		        				
		        				<div class="form-group">
		        					<div class="col-sm-2">
		        						Monto
		        					</div>
		        					<div class="col-sm-10 ">
		        						<input type="number" name="txtmontodescuento" id="txtmontodescuento" class="form-control" aria-describedby="helpBlock">
		        						<span id="helpBlock" class="help-block text-uppercase">Maximo descuento permitido </span>
		        					</div>
		        				</div>
			        		</form>
		        		</div>
		        	</div>
		        </div>
		        <!-- /.col -->
		      </div>
		      <!-- /.row --> 
		    </div>
		    <!-- ./box-body -->
		    <div class="box-footer">
		      <div class="row">
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block border-right">
		            <a class="btn btn-app"  id="btn-reset-form">
		              <i class="fa fa-refresh"></i> Limpiar
		            </a>
		          </div>
		          <!-- /.description-block -->
		        </div>
		        <!-- /.col -->
		        <div class="col-sm-3 col-xs-6">
		          <div class="description-block border-right">
		            <a class="btn btn-app">
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
		            <a class="btn btn-app" id="guardar_descuento">
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

	{{-- seccion para ver el listado de descuentos del dia  --}}
	<div class="row">
  		<div class="box box-success collapsed-box">
    		<div class="box-header with-border">
      		<h3 class="box-title">Listado de Descuentos del dia <?php echo(date('d').'/'.(date('m')).'/'.date('Y')); ?> </h3>
		      <div class="box-tools pull-right">
		        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		      </div>
    		</div>
		    <!-- /.box-header -->
		    <div class="box-body no-padding" style="display: none;">
		    	<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover" id="lista_descuentos">
								<thead>
									<tr>
										<th>N° Desc.</th>
										<th>Fecha</th>
										<th>Monto</th>
										<th>Autorizado</th>
										<th>Fecha Autorizacion</th>
										<th>Venta </th>
										<th>Usuario</th>
										<th>Fecha Ingreso</th>
										<th class="hidden-print">Acciones</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
		    </div>  
    	</div>
	</div>

</div>

<div class="modal fade" id="editardescuento">
	<div class="modal-dialog modal-sm">
	<form action="" method="POST" class="form-horizontal" role="form" id="form_modificar_descuento">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modificar Descuento</h4>
			</div>
			<div class="modal-body">
				
				<label>Monto</label>
				<input type="number" name="txtnuevomonto" id="txtnuevomonto">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="txtdescuento" id="txtdescuento">	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
				<button type="button" class="btn btn-primary btn-flat" id="btn_modificar_descuento"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Cambios</button>
			</div>
		</div>
	</form>
	</div>
</div>

@endsection

@section('mi-script')
<!-- Latest compiled and minified JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript">
var validador = 0; {{--variable para validar si debe ser enviada a aprobacion o no el descuento--}}
var porcentaje = 0; {{--variable para asignar el porcentaje de descuento--}}
$(document).on('ready',function(){
listardescuentos();
});

//funcion para guardar el monto del descuento
$('#guardar_descuento').click(function(e){
	e.preventDefault();

	if(validador == 1){
		{{--descuento se aplica automaticamente--}}
		$.ajax({
		beforeSend:function(){
		},
		url: '{{url("cobranza/aplicar_descuentos/guardar")}}',//ruta donde se enviara la informacion
		data: $('#form_aplicar_descuento').serialize(),//dato con la informacion 
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
				message: 'Descuento registrado',
			},{
				// configuracion
				type: 'success'
			});
			listardescuentos();
		})
		.fail(function(data) {
			console.log("error");
			$.notify({
				// opciones
				title: '<strong>Uuuups!</strong>',
				icon: 'fa fa-check-circle-o fa-2x',
				message: 'Algo ocurrio, favor intentelo nuevamente',
			},{
				// configuracion
				type: 'danger'
			});
		})
		.always(function(data) {
			console.log("complete");
		});	

	}else{
		{{--descuento se debe enviar para aprobar--}}

		$.ajax({
		beforeSend:function(){
		},
		url: '{{url("cobranza/aplicar_descuentos/por_aprobar")}}',//ruta donde se enviara la informacion
		data: $('#form_aplicar_descuento').serialize(),//dato con la informacion 
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
				message: 'Descuento registrado',
			},{
				// configuracion
				type: 'success'
			});
			listardescuentos();
		})
		.fail(function(data) {
			console.log("error");
			$.notify({
				// opciones
				title: '<strong>Uuuups!</strong>',
				icon: 'fa fa-check-circle-o fa-2x',
				message: 'Algo ocurrio, favor intentelo nuevamente',
			},{
				// configuracion
				type: 'danger'
			});
		})
		.always(function(data) {
			console.log("complete");
		});	
	}
});

//funcion para guardar la modificacion del monto del descuento
$('#btn_modificar_descuento').click(function(e){
	e.preventDefault();
	$.ajax({
		beforeSend:function(){
			$('#editardescuento').modal('hide');
		},
		url: '{{url("cobranza/aplicar_descuentos/modificar_descuento")}}',//ruta donde se enviara la informacion
		data: $('#form_modificar_descuento').serialize(),//dato con la informacion 
		type:'PUT',
	})
	.done(function(data) {
		console.log("success");
		$.notify({
			// opciones
			title: '<strong>Listo!</strong>',
			icon: 'fa fa-check-circle-o fa-2x',
			message: 'Descuento modificado',
		},{
			// configuracion
			type: 'success'
		});
		listardescuentos();
	})
	.fail(function(data) {
		console.log("error, folio no se encuentra en el sistema");
		$.notify({
			// opciones
			title: '<strong>Uuuups!</strong>',
			icon: 'fa fa-check-circle-o fa-2x',
			message: 'Algo ocurrio, favor intentelo nuevamente',
		},{
			// configuracion
			type: 'danger'
		});
	})
	.always(function(data) {
		console.log("complete");
	});	
});

//funcion que agrega el monto y el folio al modal para ser modificado
function editar_descuento(monto,folio){
	var monto = monto;//obtenemos el monto
	var folio = folio;//obtenemos el numero de folio
	$('#txtnuevomonto').val(monto);//asignamos el monto al input correspondiente
	$('#txtdescuento').val(folio);//asignamos el folio al input correspondiente
	$('#editardescuento').modal('show');//lanzamos el modal
}

//listado de descuentos del dia
//solo se mostraran los descuentos que se hallan ingresado durante el dia
//se podran modifiacar y/o eliminar
//funcion que trae todos los depositos ingresados el dia de hoy
function listardescuentos(){
  //buscar depositos
  var tabla = $('#lista_descuentos').DataTable({
    processing: true,
    dom: 'Bfrtip',
    destroy: true,
    buttons: [
        'excel', 'pdf','print'
    ],
    language: {
          url: 'http://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json'
    },
    "order": [[ 1, "asc" ]],
    ajax: '{{url ("cobranza/aplicar_descuentos/listar_descuentos")}}',
    columns: [
        { data: 'descuento_id', name: 'N Desc.' , },
        { data: 'descuento_fecha', name: 'Fecha descuento' },
        { data: 'descuento_monto', name: 'monto' },
        { data: 'descuento_autorizado', name: 'Autorizado' },
        { data: 'descuento_fecha_autorizado', name: 'Fecha Autorizacion' },
        { data: 'venta_id', name: 'venta' },
        { data: 'creado_por', name: 'Usuario' },
        { data: 'created_at',  name: 'Fecha Ingreso' },
    ],
    "columnDefs": [ {
        "targets": 8,
        "searchable":false,
        "data":"descuento_id",
        "render": function ( data, type, full, meta ) {
        return '<a class="btn btn-warning btn-flat" onclick="editar_descuento('+full.descuento_monto+','+full.descuento_id+')"><i class="fa fa-pencil-square-o"></i> Editar</a>  <a href="../cobranza/aplicar_descuentos/eliminar/'+data+'" class="btn btn-warning btn-flat" id="eliminar_descuento"><i class="fa fa-trash-o"></i> Eliminar</a>';
        } 
      }
    ]
    });
}

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
			if ( $('.box_datos, .nav_datos_venta, .box_datos_venta').css('display')=='block' ) {
				$('.box_datos, .nav_datos_venta, .box_datos_venta').toggle(100);
			}
			//si el div box_mensaje_error esta oculto lo muestra
			if ($('.box_mensaje_error').css('display') != 'block') {
				$('.box_mensaje_error').toggle(100);
			}

		} else {

			{{--calcularemos los dias desde el ultimo abono menos la fecha de le venta
			ese resultado se comparara con una tabla rango descuentos para determinar el porcentaje maximo de descuento
			en caso de que el descuento sea mayor a lo permitido se debe entregar la opcion de póder enviar el descuento para aprobacion
			en caso de que el descuento sea igual o menor a lo permitido, el descuento queda aplicado inmediatamente--}}
			
			var fechaventa = new Date(data[0].venta_fecha);
			var fechauabono = 0;

			{{--comenzamos a llenar los campos con datos
				creamos variables para ser utilizadas mas tarde--}}
			var abonos = 0;
			var saldo  = 0;
			{{--sumamos todos los abonos--}}
			for (var i = 0; i < data[0].abonos.length; i++) {
				abonos = abonos + data[0].abonos[i].abono_monto;

				{{--obtenemos la fecha del ultimo abono--}}
				fechauabono = new Date(data[0].abonos[i].abono_fecha_pago);
			}

			{{--verificamos si existen descuentos pendientes--}}
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

			if(data[0].descuentos.length != 0){

				if (data[0].descuentos[0].descuento_autorizado == 1) {
					$.notify({
	                // options
	                  title: '<strong>Upps!</strong>',
	                  icon: 'fa fa-exclamation-circle',
	                  message:'El folio ya tiene un descuento, el cual se encuentra aprobado',
	                },{
	                // settings
	                  type: 'success',
	                });
					$('#form_aplicar_descuento :input').attr('disabled',true);
				} else {
					$.notify({
	                // options
	                  title: '<strong>Upps!</strong>',
	                  icon: 'fa fa-exclamation-circle',
	                  message:'El folio ya tiene un descuento, el cual aun se encuentra pendiende de aprobacion',
	                },{
	                // settings
	                  type: 'warning',
	                });
					$('#form_aplicar_descuento :input').attr('disabled',true);
				}
			}

		{{-- obtenemos la cantidad de dias, fecha ultimo abono - fecha venta + 1 para que nos de el dia exacto --}}
		var diasdediferencia = (Math.round((fechauabono - fechaventa)/(1000*60*60*24)))+1 ;
		
		if (diasdediferencia <= 130) {
			validador = 1;
		}

		{{-- ahora verificamos si los dias se encuentran dentro de cierto rango para obtener el porcentaje de descuento maximo --}}
		if (diasdediferencia <= 30) {
			$('#txtmontodescuento').attr('max',(saldo * 0.40 ));
			$('#helpBlock').html('maximo descuento permitido '+ (saldo * 0.40 )   );
		} else {
			if (diasdediferencia <= 70) {
				$('#txtmontodescuento').attr('max',(saldo * 0.27 ));
				$('#helpBlock').html('maximo descuento permitido '+ (saldo * 0.27 ) );
			} else {
				if (diasdediferencia <= 100) {
					$('#txtmontodescuento').attr('max',(saldo * 0.22 ));
					$('#helpBlock').html('maximo descuento permitido '+ (saldo * 0.22 )   );
				} else {
					if (diasdediferencia <= 130) {
						$('#txtmontodescuento').attr('max', (saldo * 0.12 ));
						$('#helpBlock').html('maximo descuento permitido '+ (saldo * 0.12 ) );
					} else {
						{{--los dias son mayor a 130 por ende no se podria realizar un descuento sin pasar por aprobacion--}}
						$('#txtmontodescuento').attr('max',(saldo * 0 ));
						$('#helpBlock').html('maximo descuento permitido '+ (saldo * 0 ) );
						{{-- como la cantidad de dias supera el maximo permitido se debe enviar para aprobacion --}}
						validador = 2;
					}
				}
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
		$('#txtsector').val(data[0].sector_id);

		//carga de datos de ventas
		$('#tabla_datos_ventas').append('<tr><td>Fecha Venta</td><td>'+formatofecha(data[0].venta_fecha)+'</td><td>Total Venta</td><td>'+data[0].venta_total+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>N° Cuotas</td><td>'+data[0].venta_num_cuota+'</td><td>Valor Cuota</td><td>'+data[0].venta_monto_cuota+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Primera Cuota</td><td>'+formatofecha(data[0].venta_fecha_primer_venc)+'</td><td>Ultima Revision</td><td>'+formatofecha(data[0].venta_fecha_revision)+'</td></tr>');
		$('#tabla_datos_ventas').append('<tr><td>Forma de Pago</td><td>'+data[0].tipoformaspagos.tfp_descripcion+'</td><td>Estado Tarjeta</td><td>'+ data[0].ev_id +'</td></tr>');

		//validamos que el div box_mensaje_error no se este mostrando, de ser asi se oculta
		if ( $('.box_mensaje_error').css('display') =='block' ) {
			$('.box_mensaje_error').toggle(100);
		}
		//mostramos todos los box que se encuentran ocultos
		if ($('.box_datos, .nav_datos_venta, .box_datos_venta').css('display') != 'block') {
			$('.box_datos, .nav_datos_venta, .box_datos_venta').toggle(100);
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