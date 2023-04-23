{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.registrodesobrantecliente') }}
@endsection

@section('mi-css')

@endsection


@section('contentheader_title')
<i class="fa fa-file-text-o" aria-hidden="true"></i> Registro de Sobrante cliente
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
		<div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Datos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
            	<table class="table table-condensed">
                	<tbody>
                		<tr>
                  			<th><i class="fa fa-user" aria-hidden="true"></i> Cliente</th>
                  			<th><input type="text" name="" value="" placeholder="" class="form-control"></th>
                		</tr>
                		<tr>
                  			<th><i class="fa fa-map-marker" aria-hidden="true"></i> Sector</th>
                  			<th> <input type="text" name="" value="" placeholder="" class="form-control"> </th>
                		</tr>
                		<tr>
                  			<th><i class="fa fa-male" aria-hidden="true"></i> Cobrador</th>
                  			<th> <input type="text" name="" value="" placeholder="" class="form-control"> </th>
                		</tr>
                		<tr>
                  			<th><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Fecha cobranza</th>
                  			<th><input type="date" name="" value="" placeholder="" class="form-control"></th>
                		</tr>
                		<tr>
                  			<th><i class="fa fa-university" aria-hidden="true"></i> folio</th>
                  			<th><input type="number" name="" value="" placeholder="" class="form-control"></th>
                		</tr>
                		<tr>
                  			<th><i class="fa fa-usd" aria-hidden="true"></i> Monto</th>
                  			<th><input type="text" name="" value="" placeholder="" class="form-control"></th>
                		</tr>
                		<tr>
                  			<th><i class="fa fa-link" aria-hidden="true"></i> Observaciones</th>
                  			<th><textarea style="width: 100%; height: 50px;"></textarea></th>
                		</tr>
              		</tbody>
              		<tfoot>
              			<tr>
              				<th colspan="2">
              					<a href="#" title="" class="btn-flat btn btn-info "><i class="fa fa-search" aria-hidden="true"></i> Buscar</a>
              					<a href="#" title="" class="btn-flat btn btn-success pull-right" disabled><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</a>
              				</th>
              			</tr>
              		</tfoot>
            	</table>
            </div>
            <!-- /.box-body -->
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
            var myWindow = window.open('', 'my div', 'height=400,width=600');
            myWindow.document.write('<html><head><title>my div</title>');
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