{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 

{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.registrodedepositos') }}
@endsection

@section('mi-css')
<style type="text/css">
  .btn-app:hover{
    color:#f56954;
    box-shadow: 0 4px 7px rgba(0,0,0,.4);
  }

</style>
@endsection


@section('contentheader_title')
<i class="fa fa-file-text-o" aria-hidden="true"></i> Editor de Depositos
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
    @if ($errors->any())
       
      <div class="alert alert-danger alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Corriga los siguientes Campos: </h3>
      <ul>
        @foreach($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
      </div>
    @endif

    @if (Session::get('notice') !='')
    <div class="alert alert-info" role="alert"><p> <strong> {{ Session::get('notice') }} </strong> </p></div>
    @endif
  </div>


@foreach($depositos as $deposito)
  <p>{{$deposito->deposito_monto}}</p>
  <div class="row">
  <form action="#" method="POST" id="form_registro_deposito">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Datos de depositos</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <p class="text-center">
                <strong>Datos Generales</strong>
              </p>
              <table class="table table-condensed">
                <tbody>
                  <tr>
                    <th><i class="fa fa-male" aria-hidden="true"></i> Cobrador</th>
                    <th><input type="text" name="txtcobrador" class="form-control busquedatrabajador" value="{{$deposito->trabajadores->trabajador_id}} - {{$deposito->trabajadores->trabajador_nombres}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="txtndeposito" value="{{$deposito->deposito_id}}">
                    </th>
                  </tr>
                  <tr>
                    <th><i class="fa fa-map-marker" aria-hidden="true"></i> Sector</th>
                    <th><input type="text" name="txtsector" class="form-control busquedasector" value="{{$deposito->sectores->sector_id}} - {{$deposito->sectores->sector_descripcion}}"> </th>
                  </tr>
                  <tr>
                    <th><i class="fa fa-university" aria-hidden="true"></i> Banco</th>
                    <th><select class="form-control" name="txtbanco" id="banco"  aria-describedby="helpBlock">
                          <option value="">Seleccione...</option>
                          @foreach ($bancos as $banco)
                            <option value="{{$banco->banco_id}}" @if($deposito->bancos->banco_id == $banco->banco_id) selected="selected" @endif>{{$banco->banco_descripcion}}</option>
                          @endforeach
                        </select> 
                         <span id="helpBlock" class="help-block">Seleccione "OTROS" para caja vecina.</span>
                    </th>
                  </tr>
                  <tr>
                    <th><i class="fa fa-table" aria-hidden="true"></i> Cuenta Corriente</th>
                    <th> 
                        <select class="form-control" name="txtctacte" id="ctacte">
                          <option value="">Seleccione...</option>
                          @foreach ($ctacte as $cuenta)
                            @if($deposito->bancos->banco_id == $cuenta->banco_id )
                            <option value="{{$cuenta->cta_cte_id}}" @if($deposito->ctacte->cta_cte_id == $cuenta->cta_cte_id) selected="selected" @endif>{{$cuenta->cta_cte_descripcion}}</option>
                            @endif
                          @endforeach
                        </select>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <p class="text-center">
                <strong>Datos Deposito</strong>
              </p>
              <div class="table-responsive">
                <table class="table table-hover" id="tabla-depositos">
                  <thead>
                    <tr>
                      <td>#</td>
                      <td><i class="fa fa-calendar" aria-hidden="true"></i> Fecha Cobranza</td>
                      <td><i class="fa fa-calendar" aria-hidden="true"></i> Fecha Deposito</td>
                      <td><i class="fa fa-exchange" aria-hidden="true"></i> N° Transaccion</td>
                      <td><i class="fa fa-money" aria-hidden="true"></i> Monto</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="primer_deposito">
                      <td id="pos">1</td>
                      <td><input type="text" name="txtfechacobranza" id="fechac" class="form-control txtcalendar"></td>
                      <td><input type="text" name="txtfechadeposito" id="fechad" class="form-control txtcalendar"></td>
                      <td><input type="text" name="txtnumtransaccion" class="form-control" value="{{$deposito->deposito_num_trans}}"></td>
                      <td><input type="number" name="txtmonto" class="form-control" min="0" value="{{$deposito->deposito_monto}}"></td>
                    </tr>
                  </tbody>
                </table>
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
                <a class="btn btn-app" href="{{ URL::previous() }}">
                  <i class="fa fa-arrow-left"></i> Volver
                </a>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <a class="btn btn-app" data-toggle="modal" onClick="listar();" disabled="disabled">
                  <i class="fa fa-refresh"></i> Actualizar Lista
                </a>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <a class="btn btn-app" id="btn-guardar-deposito">
                  <i class="fa fa-edit"></i> Guardar
                </a>
                
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block">
                <a class="btn btn-app" id="btn-add-deposito" onClick="add_fila_deposito();" disabled="disabled">
                  <i class="fa fa-edit"></i> Agregar
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
  </form>
  </div>
@endforeach

</div>{{--fin container-fluid--}}



@endsection


@section('mi-script')
<script src="{{ asset('/plugins/pace.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

  //asignamos la fecha de cobranza
  var fechac = "<?php echo($deposito->deposito_fecha) ?>";
  //separamos el string por el separador "-"
  var fechacp = fechac.split("-");
  //asignamos a cada variable una parte del arreglo con su dato correspondiente
  var dia = fechacp[2];
  var mes = fechacp[1];
  var anio = fechacp[0];
  //concatenamos las variables para obtener la fecha 
  var fechacobranza = dia+'/'+mes+'/'+anio;
  //le asignamos la fecha al datepicker
  $('#fechac').datepicker('setDate',fechacobranza);

   //asignamos la fecha de cobranza
  var fechad = "<?php echo($deposito->deposito_fecha_deposito) ?>";
  //separamos el string por el separador "-"
  var fechadp = fechad.split("-");
  //asignamos a cada variable una parte del arreglo con su dato correspondiente
  var ddia = fechadp[2];
  var dmes = fechadp[1];
  var danio = fechadp[0];
  //concatenamos las variables para obtener la fecha 
  var fechadeposito= ddia+'/'+dmes+'/'+danio;
  //le asignamos la fecha al datepicker
  $('#fechad').datepicker('setDate',fechadeposito);
});
    




//funcion para buscar las cuentas corrientes asociadas a el banco
$('#banco').change( function (){
    var banco = $(this).val();
    $.ajax({
       beforeSend:function(){
        $('#ctacte').html('');
      },
      type: 'GET',
      dataType: 'json',
      data: {'banco':banco},
      url: '{{url ("cobranza/registro_depositos/obtenercuentas")}}'
    })
    .done(function(data) {
      $('#ctacte').append('<option value="0">Seleccione...</option>');
      $.each(data, function(cc_id,value){
        $("#ctacte").append('<option value="'+value.cta_cte_id+'">'+value.cta_cte_descripcion+'</option>');
            
      });
    })
    .fail(function(msg) {
      console.log("error");
    })
    .always(function(msg) {
      console.log("complete");
    });
    
  });

//funcion que registra los abonos en el sistema
$('#btn-guardar-deposito').click(function(e){
  e.preventDefault();
  var datos = $('#form_registro_deposito').serialize();
  var tk = $('input[type="hidden"]').val();
  $.ajax({
    beforeSend:function(){
    },
    url: '{{url("cobranza/registro_depositos/modificar_depositos")}}',//ruta donde se enviara la informacion
    type:"PUT",
    data: $('#form_registro_deposito').serialize(),//dato con la informacion
    error   : function ( jqXhr, json, errorThrown ){
            var errors = jqXhr.responseJSON;
            $.each( errors, function( key, value ) {
                $.notify({
                // options
                  title: '<strong>Upps!</strong>',
                  icon: 'fa fa-exclamation-circle',
                  message:value[0],
                },{
                // settings
                  type: 'danger',
                });
            }); 
          }
  })
  .done(function(data){
    console.log("success");
    if (data == 1) {
      $.notify({
      // options
        title: '<strong>Upps!</strong>',
        icon: 'fa fa-exclamation-circle',
        message:'El Deposito a sido modificado correctamente',
      },{
      // settings
        type: 'success'
      });
       window.location="{{URL::to('cobranza/registro_depositos')}}"; 
    }else {
      $.notify({
      // options
        title: '<strong>Upps!</strong>',
        icon: 'fa fa-exclamation-circle',
        message: 'Algo ocurrio al momento de actualizar el registro, Intentelo nuevamente',
      },{
      // settings
        type: 'danger',
      });
    }
    
   
  })
  .fail(function(data){
    console.log("error");
    $.notify({
      // options
        title: '<strong>Upps!</strong>',
        icon: 'fa fa-exclamation-circle',
        message: 'Algo ocurrio al momento de actualizar el registro, Intentelo nuevamente',
      },{
      // settings
        type: 'danger',
      });
  })
  .complete(function(data){
    console.log("complete");
  })
})

//datepicker para el ingreso de la fecha de abono y le pasamos como fecha maxima la de hoy
$('.txtcalendar').datepicker({
  maxDate: new Date(<?php echo(date('Y').','.(date('m')-1).','.date('d')); ?>),
  dateFormat:"dd/mm/yy",
});



//seteamos valores por defecto para el notify
$.notifyDefaults({
  placement: {
    from: "top",
    align: 'right'
  },
  animate:{
    enter: "animated bounceIn",
    exit: "animated bounceOut"
  },
  delay:2000
});

{{--//funcion para mostrar sugerencias de trabajador.--}}
$( ".busquedatrabajador" ).autocomplete({
  source: function( request, response ) {
    $.ajax( {
      url: "{{url ('buscar_trabajador') }}",
      dataType: "json",
      data: {term: request.term},
      success: function( data ) {
        var resultados = [];
        for (var prop in data) {
          resultados.push(data[prop])
        }
        response($.map( data, function( item ) {
            return {
                label: item.trabajador_id+ ' - '+item.trabajador_nombres,
                value: item.trabajador_id+ ' - '+item.trabajador_nombres
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

$( ".busquedasector" ).autocomplete({
  source: function( request, response ) {
    $.ajax( {
      url: "{{url ('buscar_sector') }}",
      dataType: "json",
      data: {term: request.term},
      success: function( data ) {
        var resultados = [];
        for (var prop in data) {
          resultados.push(data[prop])
        }
        response($.map( data, function( item ) {
            return {
                label: item.sector_codigo+ ' - '+item.sector_descripcion,
                value: item.sector_codigo+ ' - '+item.sector_descripcion
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