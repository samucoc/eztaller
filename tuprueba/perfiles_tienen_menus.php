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
                        include("modal/new_perfiles_tienen_menus.php");
                        include("modal/upd_perfiles_tienen_menus.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Perfiles tienen Menús</h2>
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

<script type="text/javascript" src="js/perfiles_tienen_menus.js"></script>

<script>
$( "#add_user" ).submit(function( event ) {
    $('#save_data').attr("disabled", true);
  
    var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/add_perfiles_tienen_menus.php",
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
            url: "action/upd_perfiles_tienen_menus.php",
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
            var m_ncorr = $("#m_ncorr"+id).val();
            var p_ncorr = $("#p_ncorr"+id).val();
            $("#mod_id").val(id);
            $("#mod_m_ncorr").val(m_ncorr);
            $("#mod_p_ncorr").val(p_ncorr);
        }
</script>