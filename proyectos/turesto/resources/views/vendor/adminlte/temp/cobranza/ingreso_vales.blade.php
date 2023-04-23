{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.ingresodevales') }}
@endsection

@section('mi-css')

@endsection


@section('contentheader_title')
<i class="fa fa-file-text-o" aria-hidden="true"></i> Ingreso de Vales 
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
				<h3 class="box-title">Seleccione una Categoria</h3>
			</div>
			<div class="box-body">
				<select class="form-control">
					<option>Seleccione...</option>
					<option>Sobrante</option>
					<option>Faltante</option>
				</select>
			</div>
		</div>
	</div>
	<br>
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			
	            <ul class="nav nav-tabs pull-right">
					<li class="active"><a href="#sobrantes" data-toggle="tab" aria-expanded="false">Sobrante</a></li>
					<li class=""><a href="#faltantes" data-toggle="tab" aria-expanded="true">Faltante</a></li>
					<li class=""><a href="#aeconomica" data-toggle="tab" aria-expanded="false">Ayuda Economica</a></li>
					<li class=""><a href="#celulares" data-toggle="tab" aria-expanded="false">Celular</a></li>
					<li class=""><a href="#pievendedores" data-toggle="tab" aria-expanded="false">Pie Vendedor</a></li>
					<li class=""><a href="#piecobradores" data-toggle="tab" aria-expanded="false">Pie Cobrador</a></li>
					<li class=""><a href="#otros" data-toggle="tab" aria-expanded="false">Otros</a></li>
	            	<li class="pull-left header">Tipo de Vale <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></li>
	            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="sobrantes">
					<div class="box">
			            <div class="box-header ">
			              <h3 class="box-title">Sobrante</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form class="form-horizontal">
			            	<div class="box-body">
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Trabajador: </label>

				                  <div class="col-sm-10">
				                    <input type="text" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha: </label>

				                  <div class="col-sm-10">
				                    <input type="date" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Folio: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Monto: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			              	</div>
			              <!-- /.box-body -->
			            	<div class="box-footer">
			                	<button type="submit" class="btn btn-default">Borrar</button>
			                	<button type="submit" class="btn btn-info pull-right">Guardar</button>
			              	</div>
			              <!-- /.box-footer -->
			            </form>
			    </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="faltantes">
                <div class="box">
			            <div class="box-header ">
			              <h3 class="box-title">Faltante</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form class="form-horizontal">
			            	<div class="box-body">
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Trabajador: </label>

				                  <div class="col-sm-10">
				                    <input type="text" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha: </label>

				                  <div class="col-sm-10">
				                    <input type="date" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Folio: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Monto: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			              	</div>
			              <!-- /.box-body -->
			            	<div class="box-footer">
			                	<button type="submit" class="btn btn-default">Borrar</button>
			                	<button type="submit" class="btn btn-info pull-right">Guardar</button>
			              	</div>
			              <!-- /.box-footer -->
			            </form>
			    </div>
              </div>
              <!-- /.tab-pane -->
              	<div class="tab-pane" id="aeconomica">
            		<div class="box">
			            <div class="box-header ">
			              <h3 class="box-title">Ayuda Economica</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form class="form-horizontal">
			            	<div class="box-body">
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Trabajador: </label>

				                  <div class="col-sm-10">
				                    <input type="text" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha: </label>

				                  <div class="col-sm-10">
				                    <input type="date" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Monto: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputPassword3" class="col-sm-2 control-label">Para: </label>

				                	<div class="col-sm-10">
				                    <input type="text" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			              	</div>
			              <!-- /.box-body -->
			            	<div class="box-footer">
			                	<button type="submit" class="btn btn-default">Borrar</button>
			                	<button type="submit" class="btn btn-info pull-right">Guardar</button>
			              	</div>
			              <!-- /.box-footer -->
			            </form>
			        </div>
              	</div>

				<div class="tab-pane" id="celulares">
					<div class="box">
			            <div class="box-header ">
			              <h3 class="box-title">Celular</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form class="form-horizontal">
			            	<div class="box-body">
			            		<div class="form-group">
				                  	<label for="inputEmail3" class="col-sm-2 control-label">Trabajador: </label>
				                  	<div class="col-sm-10">
				                    	<input type="text" class="form-control" id="" placeholder="" >
				                  	</div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha: </label>

				                  <div class="col-sm-10">
				                    <input type="date" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Monto: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputPassword3" class="col-sm-2 control-label">Mes: </label>

				                	<div class="col-sm-10">
				                    	<select class="form-control">
											<option>Seleccione...</option>
											<option>Enero</option>
											<option>Febrero</option>
											<option>Marzo</option>
											<option>Abril</option>
											<option>Mayo</option>
											<option>Junio</option>
											<option>Julio</option>
											<option>Agosto</option>
											<option>Septiembre</option>
											<option>Octubre</option>
											<option>Noviembre</option>
											<option>diciembre</option>
										</select>
				                	</div>
				                </div>
			              	</div>
			              <!-- /.box-body -->
			            	<div class="box-footer">
			                	<button type="submit" class="btn btn-default">Borrar</button>
			                	<button type="submit" class="btn btn-info pull-right">Guardar</button>
			              	</div>
			              <!-- /.box-footer -->
			            </form>
			        </div>

				</div>
              	<div class="tab-pane" id="pievendedores">
            		<div class="box">
			            <div class="box-header ">
			              <h3 class="box-title">Pie Vendedor</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form class="form-horizontal">
			            	<div class="box-body">
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Trabajador: </label>

				                  <div class="col-sm-10">
				                    <input type="text" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha: </label>

				                  <div class="col-sm-10">
				                    <input type="date" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Folio: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Monto: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			              	</div>
			              <!-- /.box-body -->
			            	<div class="box-footer">
			                	<button type="submit" class="btn btn-default">Borrar</button>
			                	<button type="submit" class="btn btn-info pull-right">Guardar</button>
			              	</div>
			              <!-- /.box-footer -->
			            </form>
			    	</div>
              	</div>
            	<div class="tab-pane" id="piecobradores">
                	<div class="box">
			            <div class="box-header ">
			              <h3 class="box-title">Pie Cobrador</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form class="form-horizontal">
			            	<div class="box-body">
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Trabajador: </label>

				                  <div class="col-sm-10">
				                    <input type="text" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha: </label>

				                  <div class="col-sm-10">
				                    <input type="date" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Folio: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Monto: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			              	</div>
			              <!-- /.box-body -->
			            	<div class="box-footer">
			                	<button type="submit" class="btn btn-default">Borrar</button>
			                	<button type="submit" class="btn btn-info pull-right">Guardar</button>
			              	</div>
			              <!-- /.box-footer -->
			            </form>
			    	</div>
            	</div>
            	<div class="tab-pane" id="otros">
            		<div class="box">
			            <div class="box-header ">
			              <h3 class="box-title">Pie Vendedor</h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form class="form-horizontal">
			            	<div class="box-body">
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Trabajador: </label>

				                  <div class="col-sm-10">
				                    <input type="text" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
			            		<div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Fecha: </label>

				                  <div class="col-sm-10">
				                    <input type="date" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Monto: </label>

				                  <div class="col-sm-10">
				                    <input type="number" class="form-control" id="" placeholder="" >
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label for="inputEmail3" class="col-sm-2 control-label">Detalle: </label>

				                  <div class="col-sm-10">
				                    <textarea style="width: 100%;height: 100px;"></textarea>
				                  </div>
				                </div>
			              	</div>
			              <!-- /.box-body -->
			            	<div class="box-footer">
			                	<button type="submit" class="btn btn-default">Borrar</button>
			                	<button type="submit" class="btn btn-info pull-right">Guardar</button>
			              	</div>
			              <!-- /.box-footer -->
			            </form>
			    	</div>
            	</div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
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