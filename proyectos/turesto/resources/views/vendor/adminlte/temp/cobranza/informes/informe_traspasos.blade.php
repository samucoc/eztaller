{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.informedetraspasos') }}
@endsection

@section('mi-css')

@endsection


@section('contentheader_title')
<i class="fa fa-files-o" aria-hidden="true"></i> Informe Traspasos
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
	            	<table class="table table-condensed" id="">
	                	<tbody>
	                		<tr>
	                			<th><i class="fa fa-calendar" aria-hidden="true"></i> Periodo:</th>
	                			<th>
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
		            				</select>
	                			</th>
	                		</tr>
	                		<tr>
	                			<th><i class="fa fa-map-marker" aria-hidden="true"></i> Sector:</th>
	                			<th colspan="2"><input type="number" name="" value="" placeholder="" class="form-control"></th>
	                		</tr>
	                		<tr>
	                			<th colspan="3">
	                				<a href="#" title="Buscar" class="btn btn-primary btn-flat pull-right"><i class="fa fa-search" aria-hidden="true"></i> Buscar</a>
	                			</th>
	                		</tr>
	              		</tbody>
	            	</table>
	            </div>
            </div>
        </div><!-- /.box-body -->
	</div>

	<div class="col-md-12" id="informe">
		<div class="box box-warning">
            <div class="box-header with-border">
            	<h3 class="box-title"><i class="fa fa-list-alt" aria-hidden="true"></i> Informe de Traspasos</h3>
            	<div class="box-tools pull-right hidden-print">
                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              	</div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        		<div class="table-responsive">
        			<table class="table ">
        				<tbody>
        					<tr>
        						<td>Sector:</td>
        						<td>23 - Placilla</td>
        					</tr>
        					<tr>
        						<td>Periodo:</td>
        						<td>Del 01/05/2017 Al 31/05/2017</td>
        					</tr>
        				</tbody>
        			</table>
        		</div>
            	
				<div class="table-responsive">
					<table class="table no-margin table-hover" >
						<thead>
							<tr>
								<th>N°</th>
								<th>Folio</th>
								<th>Folio Destino</th>
								<th>Fecha traspaso</th>
								<th>Monto</th>
								<th>Cliente</th>
								<th>Vendedor</th>
								<th>Usuario</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>986532</td>
								<td>986534</td>
								<td>01/05/2017</td>
								<td>$5.000</td>
								<td>Alverto Plaza</td>
								<td>pepito tenua</td>
								<td>sdiaz</td>
							</tr>
							<tr>
								<td>1</td>
								<td>986532</td>
								<td>986534</td>
								<td>02/05/2017</td>
								<td>$5.000</td>
								<td>Alverto Plaza</td>
								<td>pepito tenua</td>
								<td>sdiaz</td>
							</tr>
							<tr>
								<td>1</td>
								<td>986532</td>
								<td>986534</td>
								<td>03/05/2017</td>
								<td>$5.000</td>
								<td>Alverto Plaza</td>
								<td>pepito tenua</td>
								<td>sdiaz</td>
							</tr>
							<tr>
								<td>1</td>
								<td>986532</td>
								<td>986534</td>
								<td>04/05/2017</td>
								<td>$5.000</td>
								<td>Alverto Plaza</td>
								<td>pepito tenua</td>
								<td>sdiaz</td>
							</tr>
							<tr>
								<td>1</td>
								<td>986532</td>
								<td>986534</td>
								<td>04/05/2017</td>
								<td>$5.000</td>
								<td>Alverto Plaza</td>
								<td>pepito tenua</td>
								<td>sdiaz</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="7" class="text-right">Total Folios:</th>
								<th>5</th>
							</tr>
							<tr>
								<th colspan="7" class="text-right">Total Traspasos:</th>
								<th>$25.000</th>
							</tr>
						</tfoot>
					</table>
				</div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              {{--<a href="javascript:imprSelec('informe')" class="btn btn-default btn-flat pull-right hidden-print">Imprimir <i class="fa fa-print" aria-hidden="true"></i></a>--}}
              <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('informe')">
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
<script src="{{ asset('/plugins/pace.js') }}"></script>
<script type="text/javascript">
	

//no quitar...
//codigo para mostrar gif de carga en el sitio
// To make Pace works on Ajax calls
$(document).ajaxStart(function() { Pace.restart(); });
$('.ajax').click(function(){
    $.ajax({url: '#', success: function(result){
        $('.ajax-content').html('<hr>Ajax Request Completed !');
    }});
});


function imprSelec(id){

	var data=document.getElementById(id).innerHTML;
	var titulo= $('#informe .box-title').text();
    var myWindow = window.open('',titulo);//abrimos una nueva ventana, el nombre del archivo sera my div
	    myWindow.document.write('<html><head><title>'+titulo+'</title>');//agregamos las etiquetas html 
	    myWindow.document.write('<link href="{{ asset("/css/all.css") }}" rel="stylesheet" type="text/css"/>');//css
	    myWindow.document.write('<style type="text/css">.hiddenRow {padding: 0 !important;}</style>');//css personalizado
	    myWindow.document.write('</head><body >');//abrimos etiquetas body
	    myWindow.document.write(data);//agregamos el div que queremos imprimir
	    myWindow.document.write('</body></html>');//ceerramos etiquetas
    myWindow.document.close(); // necesario para IE >= 10 cerramos el archivo

    myWindow.onload=function(){ // es necesario por si el div contiene imagenes
        myWindow.focus(); // necesario para IE >= 10
        myWindow.print(); //le decimos que nos muestre la opcion de imprimir
        myWindow.close(); 
    };
}




	$( "#busquedatrabajador" ).autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "{{url ('completar') }}",
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
                    label: item.nombres,
                    value: item.nombres
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
      minLength: 2
    } );



</script>
@endsection