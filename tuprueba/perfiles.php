    <div class="" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        include("modal/new_perfil.php");
                        include("modal/upd_perfil.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Perfies</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
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

<script type="text/javascript" src="js/perfiles.js"></script>

<script>
$( "#add_user" ).submit(function( event ) {
    $('#save_data').attr("disabled", true);
  
    var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/add_perfil.php",
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
            url: "action/upd_perfil.php",
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
            var descripcion = $("#descripcion"+id).val();
            $("#mod_id").val(id);
            $("#mod_nombre").val(nombre);
            $("#mod_descripcion").val(descripcion);
        }
</script>