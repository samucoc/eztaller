<?php
    include_once "config/config.php";//Contiene funcion que conecta a la base de datos
    global $con;
    ?>    
    <div class="" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        include("modal/new_menus_hijos.php");
                        include("modal/upd_menus_hijos.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Menús Hijos</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
                                    <div id="resultados"></div><!-- Carga los datos ajax -->
                                    <div class='outer_div'></div><!-- Carga los datos ajax -->
                                <!-- /ajax -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /page content -->

<script type="text/javascript" src="js/menus_hijos.js"></script>

<script>
$( "#add_user" ).submit(function( event ) {
    $('#save_data').attr("disabled", true);
  
    var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/add_menus_hijos.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result_user").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#result_user").html(datos);
            $('#save_data').attr("disabled", false);
            load(1);
          }
    });
  event.preventDefault();
})

// success

$( "#upd_user" ).submit(function( event ) {
  $('#upd_data').attr("disabled", true);
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/upd_menus_hijos.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result_user2").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#result_user2").html(datos);
            $('#upd_data').attr("disabled", false);
            load(1);
          }
    });
  event.preventDefault();
})

    function obtener_datos(id){
            var nombre = $("#nombre"+id).val();
            var m_ncorr = $("#m_ncorr"+id).val();
            var descripcion = $("#descripcion"+id).val();
            var icono = $("#icono"+id).val();
            var link = $("#link"+id).val();
            var estado = $("#estado"+id).val();
            var orden = $("#orden"+id).val();
            $("#mod_id").val(id);
            $("#mod_m_ncorr").val(m_ncorr);
            $("#mod_nombre").val(nombre);
            $("#mod_descripcion").val(descripcion);
            $("#mod_icono").val(icono);
            $("#mod_link").val(link);
            $("#mod_estado").val(estado);
            $("#mod_orden").val(orden);
        }
</script>