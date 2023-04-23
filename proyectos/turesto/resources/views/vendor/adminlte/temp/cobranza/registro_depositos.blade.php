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
<i class="fa fa-file-text-o" aria-hidden="true"></i> Registro de Depositos
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
                    <th><input type="text" name="txtcobrador" class="form-control busquedacobrador">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </th>
                  </tr>
                  <tr>
                    <th><i class="fa fa-map-marker" aria-hidden="true"></i> Sector</th>
                    <th><input type="text" name="txtsector" class="form-control busquedasector"> </th>
                  </tr>
                  <tr>
                    <th><i class="fa fa-university" aria-hidden="true"></i> Banco</th>
                    <th><select class="form-control" name="txtbanco" id="banco" aria-describedby="helpBlock">
                          <option value="">Seleccione...</option>
                          @foreach ($bancos as $banco)
                            <option value="{{$banco->banco_id}}">{{$banco->banco_descripcion}}</option>
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
                      <td><input type="text" name="txtfechacobranza[]" class="form-control txtcalendar"></td>
                      <td><input type="text" name="txtfechadeposito[]" class="form-control txtcalendar"></td>
                      <td><input type="text" name="txtnumtransaccion[]" class="form-control"></td>
                      <td><input type="number" name="txtmonto[]" class="form-control" min="0"></td>
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
                <a class="btn btn-app"  id="btn-reset-form">
                  <i class="fa fa-eraser"></i> Limpiar
                </a>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <a class="btn btn-app" data-toggle="modal" onClick="listar();">
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
                <a class="btn btn-app" id="btn-add-deposito" onClick="add_fila_deposito();">
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
  
<div class="row">
  <div class="col-md-12">
  <div class="box box-success collapsed-box">
    <div class="box-header with-border">
      <h3 class="box-title">Listado de Depositos del dia <?php echo(date('d').'/'.(date('m')).'/'.date('Y')); ?> </h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding" style="display: none;">
      <div class="table-responsive">
        <table class="table table-hover" id="lista_depositos">
          <thead>
            <tr>
              <th>Monto</th>
              <th>Fecha Cobranza</th>
              <th>N° Trans</th>
              <th>Fecha Deposito</th>
              <th>Sector</th>
              <th>Banco</th>
              <th>Cuenta Corriente</th>
              <th>Cobrador</th>
              <th>Usuario</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      </div>  
    </div>
    <!-- /.box-body -->
  </div>
</div> 

</div>{{--fin container-fluid--}}



@endsection


@section('mi-script')
<script type="text/javascript">

$(document).on('ready',function(){
listar();
});

//funcion que trae todos los depositos ingresados el dia de hoy
function listar(){
  //buscar depositos
  var tabla = $('#lista_depositos').DataTable({
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
    ajax: '{{url ("cobranza/registro_depositos/listar")}}',
    columns: [
        { data: 'deposito_monto', name: 'monto' , },
        { data: 'deposito_fecha', name: 'Fecha cobranza' },
        { data: 'deposito_num_trans', name: 'N° trans' },
        { data: 'deposito_fecha_deposito', name: 'Fecha deposito' },
        { data: 'sectores.sector_descripcion', name: 'Sector' },
        { data: 'bancos.banco_descripcion', name: 'Banco' },
        { data: 'ctacte.cta_cte_descripcion', name: 'Cuenta Corriente' },
        { data: 'trabajadores.trabajador_nombres',  name: 'Cobrador' },
        { data: 'creado_por',  name: 'Usuario' },
        { data: 'deposito_id', name: 'N°'}
    ],
    "columnDefs": [ {
        "targets": 9,
        "searchable":false,
        "data":"deposito_id",
        "render": function ( data, type, full, meta ) {
        return '<a href="../cobranza/registro_depositos/editar/'+data+'" class="btn btn-warning btn-flat" id="editar_deposito"><i class="fa fa-pencil-square-o"></i> Editar</a>';
        } 
      }
    ]
    });
}
  
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
    url: '{{url("cobranza/registro_depositos/registrar_depositos")}}',//ruta donde se enviara la informacion
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
    $.notify({
    // options
      title: '<strong>Upps!</strong>',
      icon: 'fa fa-exclamation-circle',
      message:'El/los Deposito/s se registraron correctamente',
    },{
    // settings
      type: 'success'
    });
    listar();
    $('#form_registro_deposito')[0].reset();
    $('#tabla-depositos tbody tr').not(':first').remove();
  })
  .fail(function(data){
    console.log("error");
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

function add_fila_deposito(){
  
  var posicion = $('#tabla-depositos tbody tr:last td:first').text();
  var posicion = ++posicion;
  if (posicion >10) {
    $.notify({
      // options
      title: '<strong>Upps!</strong>',
      icon: 'fa fa-exclamation-circle',
      message: 'Llegaste al maximo de depositos permitidos, favor registra estos abonos para poder ingresar mas',
    },{
      // settings
      type: 'warning'
    });

  } else {
    $('#tabla-depositos tbody tr:last').after('<tr class="animated fadeIn" ><td>'+posicion+'</td><td><input type="text" name="txtfechacobranza[]" class="form-control txtcalendar "></td><td><input type="text" name="txtfechadeposito[]" class="form-control txtcalendar "></td><td><input type="text" name="txtnumtransaccion[]" class="form-control "></td><td><input type="number" name="txtmonto[]" class="form-control" min="0"></td></tr>');
    
    $('.txtcalendar').datepicker({
      maxDate: new Date(<?php echo(date('Y').','.(date('m')-1).','.date('d')); ?>),
      dateFormat:"dd/mm/yy",
    });
  }//fin if
}//fin function add_fila_deposito


{{--funcion para limpiar el formulario--}}
$('#btn-reset-form').click(function(){
  $('#form_registro_deposito')[0].reset();
  $('#tabla-depositos tbody tr').not(':first').remove();
})

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