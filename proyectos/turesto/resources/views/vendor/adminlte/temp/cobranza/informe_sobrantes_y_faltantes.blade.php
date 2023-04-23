{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.informedesobrantesyfaltantes') }}
@endsection

@section('mi-css')

@endsection


@section('contentheader_title')
<i class="fa fa-file-text-o" aria-hidden="true"></i> Informe de Sobrantes y Faltantes
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
              <h3 class="box-title"><i class="fa fa-database" aria-hidden="true"></i> Datos</h3>
            </div>
            <!-- /.box-header -->
            <div class="table-responsive">
            <div class="box-body no-padding">
            	<table class="table table-condensed" id="">
            		<thead>
            			<tr>
            				<td><i class="fa fa-male" aria-hidden="true"></i> Cobrador</td>
            				<td><i class="fa fa-map-marker" aria-hidden="true"></i> Sector</td>
            				<td colspan="2"><i class="fa fa-sliders" aria-hidden="true"></i> Rango </td>
            				
            			</tr>
            		</thead>
                	<tbody>
                		<tr>
                  			<th><input type="text" name="" value="" placeholder="" class="form-control"></th>
                  			<th><input type="text" name="" value="" placeholder="" class="form-control"></th>
                  			<th colspan="2">
                  				<select name="meses" class="form-control">
                  					<option value="">seleccione...</option>
                  					<option value="">Enero</option>
                  					<option value="">febrero</option>
                  					<option value="">Marzo</option>
                  					<option value="">Abril</option>
                  					<option value="">Mayo</option>
                  					<option value="">Junio</option>
                  					<option value="">Julio</option>
                  					<option value="">Agosto</option>
                  					<option value="">Septiembre</option>
                  					<option value="">Octubre</option>
                  					<option value="">Noviembre</option>
                  					<option value="">diciembre</option>
                  				</select>
                  			</th>
                  			
                  			<th><a href="#" title="Buscar" class="btn btn-info btn-flat"><i class="fa fa-search" aria-hidden="true"></i> Buscar</a></th>
                		</tr>
                		
              		</tbody>
            	</table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
	</div>

	<div class="col-md-12" id="muestra">
			<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list-alt" aria-hidden="true"></i> Informe de Sobrantes y Faltantes</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<div>
            		<div class="table-responsive">
            			<table class="table table-hover">
            				<tbody>
            					<tr>
            						<td>Cobrador:</td>
            						<td>juanito Perez Perez</td>
            					</tr>
            					<tr>
            						<td>Sector:</td>
            						<td>23 - Placilla</td>
            					</tr>
            					<tr>
            						<td>Periodo:</td>
            						<td>Marzo</td>
            					</tr>
            				</tbody>
            			</table>
            		</div>
            	</div>
				<div class="table-responsive">
					<table class="table no-margin">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Cobranza</th>
								<th>Deposito</th>
								<th>S. cliente</th>
								<th>S. No Utilizado</th>
								<th>Diferencia</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>01/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>02/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>03/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>04/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>05/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>06/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>07/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>08/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>09/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>10/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>11/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>12/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>13/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>14/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>15/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>16/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>17/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>18/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>19/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>20/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
							<tr>
								<td>21/04/2017</td>
								<td>150.000</td>
								<td>150.000</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5" class="text-right">Total cobranzas: </th>
								<th>3150000</th>
							</tr>
							<tr>
								<th colspan="5" class="text-right">Total Depositos: </th>
								<th>3150000</th>
							</tr>
							<tr>
								<th colspan="5" class="text-right">Total sobrantes clientes: </th>
								<th>0</th>
							</tr>
							<tr>
								<th colspan="5" class="text-right">Total Sobrantes No Asignados: </th>
								<th>0</th>
							</tr>
							<tr>
								<th colspan="5" class="text-right">Total Diferencias: </th>
								<th>0</th>
							</tr>
							<tr>
								<th colspan="5" class="text-right">Total vales: </th>
								<th>0</th>
							</tr>
							<tr>
								<th colspan="5" class="text-right">total: </th>
								<th>3150000</th>
							</tr>
						</tfoot>
					</table>
				</div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              {{--<a href="javascript:imprSelec('muestra')" class="btn btn-default btn-flat pull-right hidden-print" id="informesobrantes"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>--}}
              
              <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('muestra')">
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
	
$('#btn-add-deposito').click(function(e){
	e.preventDefault();
	$('#tabla-depositos tbody tr:last').after('<tr style="display: none;"><th><input type="date" name="" value="" placeholder="" class="form-control"></th><th><input type="date" name="" value="" placeholder="" class="form-control"></th>                  			<th><input type="text" name="" value="" placeholder="" class="form-control"></th><th><input type="number" name="" value="" placeholder="" class="form-control" min="0"></th><th></th></tr>').fadeIn(500);
});

	//codigo para mostrar gif de carga en el sitio
	// To make Pace works on Ajax calls
	$(document).ajaxStart(function() { Pace.restart(); });
    $('.ajax').click(function(){
        $.ajax({url: '#', success: function(result){
            $('.ajax-content').html('<hr>Ajax Request Completed !');
        }});
    });


function imprSelec(muestra){
	var data=document.getElementById(muestra).innerHTML;
    var titulo= $('#muestra .box-title').text();
    var myWindow = window.open('',titulo);//abrimos una nueva ventana, el nombre del archivo sera my div
	    myWindow.document.write('<html><head><title>'+titulo+'</title>');//agregamos las etiquetas html 
        myWindow.document.write('<link href="{{ asset("/css/all.css") }}" rel="stylesheet" type="text/css" media="all" />');
        myWindow.document.write('<style type="text/css">.hiddenRow {padding: 0 !important;}</style>');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');
        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload=function(){ // necessary if the div contain images

            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
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