{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}
{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.informedecobranza') }}
@endsection

@section('mi-css')
<style type="text/css">
.hiddenRow {
	padding: 0 !important;
}
.colapsable{
	padding: 0;
	line-height: 0.1;
}
.colapsable table{
	margin-top: 10px;
}
.colapsable a{
	margin:0;
	padding:1px 2px;
}
</style>
@endsection

@section('contentheader_title')
<i class="fa fa-files-o" aria-hidden="true"></i> Informe Cobranza
@endsection

@section('contentheader_description')
@endsection
{{-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
--}}
@section('main-content')
<div class="container-fluid spark-screen" >


<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
            <div class="box-header">
            	<h3 class="box-title"><i class="fa fa-database" aria-hidden="true"></i> Datos Requeridos</h3>
            </div>
            <!-- /.box-header -->
            <div class="table-responsive">
            <div class="box-body no-padding">
              <form action="" method="POST" class="form-horizontal" role="form" id="form_buscar_cobranzas">
            	<table class="table table-condensed" id="">
                	<tbody>
                		<tr>
                			<th><i class="fa fa-list-alt" aria-hidden="true"></i> Periodo:</th>
                			<th>
                				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                				<select name="rango_meses" class="form-control">
                					<option value="0">Seleccione...</option>
                					<option value="1">Enero</option>
                					<option value="2">Febrero</option>
                					<option value="3">Marzo</option>
                					<option value="4">Abril</option>
                					<option value="5">Mayo</option>
                					<option value="6">Junio</option>
                					<option value="7">Julio</option>
                					<option value="8">Agosto</option>
                					<option value="9">Septiembre</option>
                					<option value="10">Octubre</option>
                					<option value="11">Noviembre</option>
                					<option value="12">Diciembre</option>
                					<option value="13">Personalizado</option>
                				</select>
                			</th>
                		</tr>
                		<tr style="display: none;" id="rango_personalizado">
                			<th><i class="fa fa-list-alt" aria-hidden="true"></i> Rango:</th>
                			<th>
                				<div class="input-group">
						        	<input name="fdesde" id="fdesde" type="text" class="form-control col-xs-3 col-md-3 fecha_tope">
						        	<span class="input-group-addon">al</span>
						        	<input name="fhasta" id="fhasta" type="text" class="form-control col-xs-3  col-md-3 fecha_tope">
						        </div>
                			</th>
                		</tr>
                		<tr>
                			<th><i class="fa fa-map-marker" aria-hidden="true"></i> Sector:</th>
                			<th colspan="2"><input type="text" name="txtsector" class="form-control busquedasector"></th>
                		</tr>
                		<tr>
                			<th><i class="fa fa-male" aria-hidden="true"></i> Cobrador:</th>
                			<th colspan="2"><input type="text" name="txtcobrador" class="form-control busquedacobrador"></th>
                		</tr>
                		<tr>
                			<th>
                				<button type="button" id="btnlimpiar" class="btn bg-teal btn-flat"><i class="fa fa-refresh" aria-hidden="true"></i> Limpiar</button>
                			</th>
                			<th>
                				<button type="submit" class="btn btn-primary btn-flat pull-right"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                			</th>
                		</tr>
              		</tbody>
            	</table>
              </form>
            </div>
            </div>
        </div>
	</div>
	<div class="col-md-12" id="informe_cobranza" style="display: none;">
		<div class="box box-warning">
            <div class="box-header with-border">
            	<h3 class="box-title"><i class="fa fa-list-alt" aria-hidden="true"></i> Informe de cobranza</h3>
            	<div class="box-tools pull-right">
                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              	</div>
            </div>
            <div class="box-body" >
        		<div class="table-responsive">
        			<table class="table table-hover" id="tabla_encabezado">
        				<tbody>
        					<tr>
        						<td>Cobrador:</td>
        						<td id="tabla_dato_cobrador"></td>
        						<td>Comision:</td>
        						<td id="tabla_dato_comision">10%</td>
        					</tr>
        					<tr>
        						<td>Sector:</td>
        						<td id="tabla_dato_sector"></td>
        						<td>Periodo:</td>
        						<td id="tabla_dato_periodo"></td>
        					</tr>
        				</tbody>
        			</table>
        		</div>
        		<div class="col-md-12">
    				<div class="col-md-1 col-xs-2 ">N°</div>
        			<div class="col-md-2 col-xs-2">Fecha</div>
        			<div class="col-md-2 col-xs-2">Cobranza</div>
        			<div class="col-md-2 col-xs-2">Comision</div>
        			<div class="col-md-2 col-xs-2">Total Folios</div>
        			<div class="col-md-2 col-xs-2">Estado</div>
        		</div>
				<div class="clearfix"></div>
        		<hr style="border:1px solid;opacity: 0.5" class="clearfix">
        		<div class="clearfix"></div>
        		<div id="listado_cobranzas"></div>
            </div>      
            <div class="box-footer clearfix">
              <a class="btn btn-app pull-right hidden-print" href="javascript:imprimir('informe_cobranza')">
                <i class="fa fa-print" aria-hidden="true"></i> Imprimir
              </a>
            </div>
        </div>
	</div>

</div>
</div>

@endsection

@section('mi-script')
<script type="text/javascript">
{{--seleccionamos el mes en el que se quiere buscar las cobranzas--}}
$('select[name=rango_meses]').change(function(){
	if ($(this).val()==13) {
		document.getElementById('rango_personalizado').style.display='table-row';
	} else {
		document.getElementById('rango_personalizado').style.display='none';
	}
});

$(document).on('click','.view',function(e){
	e.preventDefault();
	$(this).parent().parent().next().toggle(100);
})

$(document).on('click','.print',function(){
 imprimir($(this).attr('name'));
});


$('#btnlimpiar').click(function(){
	$('#form_buscar_cobranzas')[0].reset();

	$('#informe_cobranza').css('display','none');
	$('#tabla_dato_cobrador').html('');
	$('#tabla_dato_comision').html('');
	$('#tabla_dato_sector').html('');
	$('#tabla_dato_periodo').html('');
	$('#listado_cobranzas').html('');
});
$('#form_buscar_cobranzas').submit(function(e){
	e.preventDefault();
	$.ajax({
			beforeSend:function(){
				//antes de consultar borramos lo que se encuentre en la tabla encabezado y el box con el listado 
				$('#tabla_dato_cobrador').html('');
				$('#tabla_dato_comision').html('');
				$('#tabla_dato_sector').html('');
				$('#tabla_dato_periodo').html('');
				$('#listado_cobranzas').html('');
			},
			url: '{{url("cobranza/informes/informe_cobranza/buscar_cobranzas")}}',//ruta donde se enviara la informacion
			type: 'PUT',
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
			var largo = data.length;
			var cobrador = $('#form_buscar_cobranzas input[name="txtcobrador"]').val();
			var sector = $('#form_buscar_cobranzas input[name="txtsector"]').val();
			var periodo = formatofecha(data[largo -1].fecha_ini) + ' al '+formatofecha(data[largo -1].fecha_fin);
			{{--llenamos los datos del encabezado--}}
			$('#tabla_dato_cobrador').append(cobrador);
			$('#tabla_dato_comision').append('10%');
			$('#tabla_dato_sector').append(sector);
			$('#tabla_dato_periodo').append(periodo);

			var fecha_ini        = new Date(data[largo -1 ].fecha_ini);//fecha de comienzo
			var fecha_fin        = new Date(data[largo -1 ].fecha_fin);//fecha termino
			var dia              = 0;//dia del mes
			var mes              = 0;//mes del año 
			var anio             = 0;//año 
			var fecha            = 0;//fecha compuesta por dia/mes/año
			var contador         = 1;//conteo de dias del mes
			var fcount           = 0;//conteo de folios
			var primero          = '';//variable que concadena la estructura del box
			var listado          = '';//variable que concadena las cobranzas 
			var ultimo           = '';//variable que concadena el pie del box
			var cobranza         = 0;//sumatoria de las cobranzas
			var depositos        = 0;//sumatoria de los depositos
			var totalcobranza    = 0;//total de todas las cobranzas del periodo señalado
			var totalfolios      = 0;//total de folio del periodo
			var totalcomision    = 0;//comision total del mes del cobrador
			var totaldepositos   = 0;//sumatoria de los depositos hechos por el cobrador
			var mensaje          = '';
			var fecha_deposito   = 'Sin Deposito';
			var deposito_conf    = 'NO';
			var deposito_usuario = 'Sin Usuario';
			//creamos un ciclo para recorrer todas las fechas desde la fecha de inicio hasta la fecha de termino
			for (var i = new Date(fecha_ini); i <= fecha_fin ; i.setDate(i.getDate() + 1)) {
				//verificamos si el navegador es mozilla
				//para evitar el bug que resta un dia a la fecha
				if (navigator.appCodeName == 'Mozilla') {
					dia = ( (i.getDate()+1) <10) ? ('0'+(i.getDate()+1)  ) : (i.getDate()+1) ;//obtenemos el dia	
				}else{
					dia = (i.getDate() <10) ? ('0'+i.getDate() ) : i.getDate();//obtenemos el dia
				}
				mes = ((i.getMonth()+1)<10) ? '0'+(i.getMonth()+1) : (i.getMonth()+1);//obtenemos el mes
				//obtenemos la fecha
				fecha = dia+'/'+ mes +'/'+i.getFullYear();//concadenamos el dia/mes/año
				
				
				//creamos el listado con los abonos que concuerden con la fecha 
				for (var x = 0; x < (data.length - 1); x++) {
					//si la fecha coincide con la fecha del abono se lista el abono para luego ingresarlo dentro del listado completo de dias
					if(fecha == formatofecha(data[x].abono_fecha_pago)){
					
					listado = listado + '<tr><td>'+(x+1)+'</td><td>'+data[x].ventas.venta_id+'</td><td>'+data[x].supervisor.trabajador_id+' '+data[x].supervisor.trabajador_nombres +'</td><td>'+data[x].ventas.clientes.cliente_nombres+'</td><td>'+data[x].abono_monto+'</td></tr>';
					
					cobranza = cobranza + data[x].abono_monto;//sumamos el monto de todos los folios para compararlo luego con el deposito
					fcount++;

					}
					//validamos si la fecha coincide con al fecha del deposito para asignar el monto a el dia
					if (fecha == formatofecha(data[x].trabajador.depositos.deposito_fecha)) {
						depositos = data[x].trabajador.depositos.deposito_monto;
						if(depositos >0 || depositos != null){
							fecha_deposito = data[x].trabajador.depositos.created_at;
							deposito_conf = data[x].trabajador.depositos.deposito_revisado;
							deposito_usuario = data[x].trabajador.depositos.deposito_revisado_por;
						}

					}

				}

				totaldepositos = totaldepositos + depositos;
				totalcobranza = totalcobranza + cobranza;
				totalfolios = totalfolios + fcount;//sumamos todos los folios del periodo

				if (depositos == 0 || depositos == null) {
					mensaje = '<span class="label label-danger hidden-print">Sin deposito asociado</span><span class="visible-print">NO</span>';
				}else{
					if (cobranza < depositos) {
						mensaje = '<span class="label label-warning hidden-print">Cobranza no cuadra</span><span class="visible-print">NO</span>';
					}else{
						if (cobranza > deposito) {
							mensaje = '<span class="label label-warning hidden-print">Deposito no cuadra</span><span class="visible-print">NO</span>';
						}else{
							if (cobranza == depositos) {
								mensaje = '<span class="label label-success hidden-print">OK</span><span class="visible-print">Si</span>';
							}
						}
					}
				}


				primero = '<div class="row colapsable"><div class="col-md-12"><div class="col-md-2 col-xs-2 ">'+contador+'</div><div class="col-md-2 col-xs-2">'+fecha+'</div><div class="col-md-2 col-xs-2">'+cobranza+'</div><div class="col-md-2 col-xs-2">'+(cobranza*0.1)+'</div><div class="col-md-2 col-xs-2">'+fcount+'</div><div class="col-md-2 col-xs-2">'+mensaje+'<a class="btn hidden-print print" name="p_'+fecha+'" data-toggle="tooltip" data-placement="top" title="Imprimir"><i class="fa fa-print"></i></a><a class="btn hidden-print view" data-toggle="tooltip" data-placement="top" title="Ver Folios"><i class="fa fa-eye"></i></a></div></div><div class="col-md-12" style="display: none;" id="p_'+fecha+'" ><h3>Cobranza Dia '+fecha+'</h3><p>Cobrador: <span>'+cobrador+'</span></p><p>Sector: <span>'+sector+'</span></p><p>Deposito: <span>'+depositos+'</span></p><p>Fecha Ingreso: <span>'+fecha_deposito+'</span></p><p>Confirmado: <span>'+deposito_conf+'</span></p><p>Usuario: <span>'+deposito_usuario+'</span></p><table class="table table-condensed" ><thead><tr><th>N°</th><th>Folio</th><th>Supervisor</th><th>Cliente</th><th>Abono</th></tr></thead><tbody>';

				ultimo = '</tbody></table></div></div><div class="clearfix"></div><hr><div class="clearfix"></div>';
				
				$('#listado_cobranzas').append(primero+''+listado+''+ultimo);

				contador++;//aumentamos el contador de dias.
				depositos = 0;
				cobranza  =0;//volvemos a setear la cobranza en cero
				fcount    = 0;//seteamos el cntador de folios en cero
				primero   ='';//borramos el contenido de la variable
				listado   ='';//borramos el contenido de la variable
				ultimo    ='';//borramos el contenido de la variable
				mensaje = '';
			}
				$('#listado_cobranzas').append('<table class="table table-condensed"><tr><td class="text-right">Total Cobranzas</td><td>'+totalcobranza+'</td></tr><tr><td class="text-right">Total Depositos</td><td>'+totaldepositos+'</td></tr><tr><td class="text-right">Total Comision</td><td >'+(totalcobranza*0.1)+'</td></tr><tr><td class="text-right">Total Folios</td><td>'+totalfolios+'</td></tr>');

				$('#informe_cobranza').fadeIn(100);
		})
		.fail(function(data) {
			console.log("error");
		})
		.always(function(data) {
			console.log("complete");
		});
});


{{--funcion para buscar los sectores--}}
$( ".busquedasector" ).autocomplete({
  source: function( request, response ) {
    $.ajax( {
      url: "{{url ('buscar_sector') }}",
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
                label: item.sector_id+' - '+item.sector_descripcion,
                value: item.sector_id+' - '+item.sector_descripcion
            }
        }));
      },
      select: function(event,ui){
      	event.preventDefault();
      	$("#busquedatrabajador").attr({
      		name: ui.label,
      		value: ui.value
      	});
      }
    } );
  },
  minLength: 1
});
	

  //funcion para imprimir usando window.print()
  function imprimir(id){
      var data=document.getElementById(id).innerHTML;
      var titulo= $('#informe .box-title').text();
      var myWindow = window.open('',titulo);//abrimos una nueva ventana, el nombre del archivo sera my div
      myWindow.document.write('<html><head><title>'+titulo+'</title>');//agregamos las etiquetas html 
      myWindow.document.write('<link href="{{ asset("/css/all.css") }}" rel="stylesheet" type="text/css" media="all" />');
      myWindow.document.write('<style type="text/css">.hiddenRow {padding: 0 !important;}.colapsable{padding: 0;line-height: 0.01;}</style>');
      myWindow.document.write('</head><body >');
      myWindow.document.write(data);
      myWindow.document.write('</body></html>');
      myWindow.document.close(); // necessary for IE >= 10
      myWindow.onload=function(){ // necessary if the div contain images
      myWindow.focus(); // necessary for IE >= 10
      myWindow.print();
      myWindow.close();
      };
  }//fin funcion imprselect

</script>
@endsection






