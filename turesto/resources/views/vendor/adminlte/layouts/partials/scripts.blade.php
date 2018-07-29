<!-- REQUIRED JS SCRIPTS -->
<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<!-- jQuery -->
<script src="http://code.jquery.com/jquery.js"></script>

<!-- DataTables -->
<script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

<!-- App scripts -->
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="http://1000hz.github.io/bootstrap-validator/dist/validator.min.js"></script>



<script src="{{ asset('/plugins/bootstrap-notify.min.js') }}"></script>
<script type="text/javascript" src="{{asset('/plugins/jquery.slimscroll.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/plugins/jquery-ui.min.js')}}"></script>
<script src="{{ asset('/plugins/pace.js') }}"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
    
  //codigo para mostrar gif de carga en el sitio
	// To make Pace works on Ajax calls
	$(document).ajaxStart(function() {
    Pace.restart();
  });

  $('.ajax').click(function(){
    $.ajax({url: '#', success: function(result){
        $('.ajax-content').html('<hr>Ajax Request Completed !');
    }});
  });

  //funcion para darle formato dd/mm/yyyy a laas fechas
  function formatofecha(fecha){
    var t = fecha.split(/[- :]/);
    var fulldate = t[2]+'/'+t[1]+'/'+t[0];
    return fulldate;
  }


  //seteamos valores por defecto para el notify
  $.notifyDefaults({
    placement: {
      from: "top",
      align: 'center'
    },
    animate:{
      enter: "animated bounceIn",
      exit: "animated bounceOut"
    },
    delay:2000
  });


  //le damos el foco al input buscar folio
  $('#txtfoliobuscar').focus();


  //datepicker para el ingreso de la fecha de abono y le pasamos como fecha maxima la de hoy
  $('.fecha_tope').datepicker({
    maxDate: new Date(<?php echo(date('Y').','.(date('m')-1).','.date('d')); ?>),
    dateFormat:"dd/mm/yy",
  });


  //funcion para imprimir usando window.print()
  function imprSelec(id){
      var data=document.getElementById(id).innerHTML;
      var titulo= $('#informe .box-title').text();
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
  }//fin funcion imprselect

  //funcion para buscar trabajador
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
                  label: item.trabajador_id+ ' - '+item.trabajador_nombres+ ' '+item.trabajador_ap,
                  value: item.trabajador_id+ ' - '+item.trabajador_nombres+ ' '+item.trabajador_ap
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


  //funcion para buscar cobrador
  $( ".busquedacobrador" ).autocomplete({
    source: function( request, response ) {
      $.ajax( {
        url: "{{url ('buscar_cobrador') }}",
        dataType: "json",
        data: {term: request.term},
        success: function( data ) {
          var resultados = [];
          for (var prop in data) {
            resultados.push(data[prop])
          }
          response($.map( data, function( item ) {
              return {
                  label: item.trabajador_id+ ' - '+item.trabajador_nombres+ ' '+item.trabajador_ap,
                  value: item.trabajador_id+ ' - '+item.trabajador_nombres+ ' '+item.trabajador_ap
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



  //funcion para buscar supervisor
  $( ".busquedasupervisor" ).autocomplete({
    source: function( request, response ) {
      $.ajax( {
        url: "{{url ('buscar_supervisor') }}",
        dataType: "json",
        data: {term: request.term},
        success: function( data ) {
          var resultados = [];
          for (var prop in data) {
            resultados.push(data[prop])
          }
          response($.map( data, function( item ) {
              return {
                  label: item.trabajador_id+ ' - '+item.trabajador_nombres+ ' '+item.trabajador_ap,
                  value: item.trabajador_id+ ' - '+item.trabajador_nombres+ ' '+item.trabajador_ap
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
