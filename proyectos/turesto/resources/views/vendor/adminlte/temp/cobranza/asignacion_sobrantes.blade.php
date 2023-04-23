{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.asignaciondesobrantes') }}
@endsection

@section('mi-css')

@endsection


@section('contentheader_title')
<i class="fa fa-file-text-o" aria-hidden="true"></i> asignacion Sobrantes
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
	<div class="col-sm-12">
		<h3>Buscador con sugerencias</h3>
		<div class="ui-widget">
		<input type="text" name="" value="" placeholder="" id="busquedatrabajador" class="form-control">
		</div>
	</div>
</div>

<br><br>

<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i> Busqueda de Sobrantes de clientes</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Sector</th>
								<th>Rango</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="number" name="" value="" placeholder="" class="form-control"></td>
								<td>
									<div class="input-group">
							        	<input name="fdesde" id="fdesde" type="date" required class="form-control col-xs-3 col-md-3">
							        	<span class="input-group-addon">al</span>
							        	<input name="fhasta" id="fhasta" type="date" required class="form-control col-xs-3  col-md-3">
							        </div>
								</td>
								<td> <a href="#" title="buscar" class=" btn btn-primary btn-flat"><i class="fa fa-search" aria-hidden="true"></i> Buscar</a> </td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12" id="informe">
			<div class="box box-warning">
            <div class="box-header with-border">
            	<h3 class="box-title"><i class="fa fa-list-alt" aria-hidden="true"></i> Listado de Sobrantes de cliente</h3>
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
            						<td>Sector:</td>
            						<td>23 - Placilla</td>
            					</tr>
            					<tr>
            						<td>Rango Fecha:</td>
            						<td>desde 01/05/2017 al 08/05/2017</td>
            					</tr>
            				</tbody>
            			</table>
            		</div>
            	</div>
				<div class="table-responsive">
					<table class="table no-margin">
						<thead>
							<tr>
								<th>Folio</th>
								<th>Cobrador</th>
								<th>Fecha</th>
								<th>Observaciones</th>
								<th>Cliente</th>
								<th>Monto</th>
								<th>Monto Utilizado</th>
								<th>Fecha Utilizacion</th>
								<th>Disponible</th>
								<th class="hidden-print">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>986563</td>
								<td>Juanito Perez</td>
								<td>01/04/2017</td>
								<td>vta por aprobar</td>
								<td>Ana Maria</td>
								<td>150.000</td>
								<td>0</td>
								<td>sin registro</td>
								<td>150.000</td>
								<td class="hidden-print" ><a data-toggle="modal" href='#asignarsobrante' class="btn btn-flat btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Asignar</a></td>	
							</tr>
						</tbody>
					</table>
				</div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              {{--<a href="javascript:imprSelec('informe')" class="btn btn-success btn-flat pull-right hidden-print"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>--}}
              
              <a class="btn btn-app pull-right hidden-print text-danger" href="javascript:imprSelec('informe')">
                <i class="fa fa-print" aria-hidden="true"></i> Imprimir
              </a>
            </div>
            <!-- /.box-footer -->
          </div>
	</div>
</div>

</div>



<div class="modal fade" id="asignarsobrante">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Asingacion de Sobrante de Cliente</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Monto Registrado</th>
								<th>Monto Utilizado</th>
								<th>Monto Disponible</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span class="text-info">150.000</span></td>
								<td><span class="text-danger">0</span></td>
								<td><span class="text-success">80.000</span></td>
							</tr>
						</tbody>
					</table>
				</div>
					<hr style="border: 1px solid; opacity: 0.5;" class="text-danger">
				<div class="table-responsive">
					<table class="table table-hover">
						<tbody>
							<tr>
								<td>Fecha Cobranza:</td>
								<td><input type="date" name="" value="" placeholder="" class="form-control"></td>
							</tr>
							<tr>
								<td>Folio:</td>
								<td><input type="number" name="" value="" placeholder="" class="form-control"></td>
							</tr>
							<tr>
								<td>Cobrador:</td> 
								<td><input type="text" name="" value="" placeholder="" class="form-control"></td>
							</tr>
							<tr>
								<td>Monto a Asignar:</td>
								<td><input type="number" name="" value="" placeholder="" class="form-control"></td>
							</tr>
							<tr>
								<td>Observaciones:</td>
								<td> <textarea name="observacion" minlength="5" maxlength="50" class="form-control"></textarea> </td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
				<button type="button" class="btn btn-primary btn-flat"><i class="fa fa-exchange" aria-hidden="true"></i> Asignar</button>
			</div>
		</div>
	</div>
</div>


@endsection


@section('mi-script')

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
	var titulo= $('#informe .box-title').text();
    var myWindow = window.open('',titulo);//abrimos una nueva ventana, el nombre del archivo sera my div
	    myWindow.document.write('<html><head><title>'+titulo+'</title>');//agregamos las etiquetas html 
        myWindow.document.write('<link href="{{ asset("/css/all.css") }}" rel="stylesheet" type="text/css" media="all" />');
        myWindow.document.write('<style type="text/css" media="print">@page { size: landscape; }</style>');//css
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