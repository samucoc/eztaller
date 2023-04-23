<?php
    include_once "config/config.php";//Contiene funcion que conecta a la base de datos
    global $con;
    ?>    
    <div class="" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <h3>Imprime Guía</h3>
                <div id="resultado_accion"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <input type="text" name="m_ncorr" id="m_ncorr" class="form-control pull-right" >
                        <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button id="save_data" type="button" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    
                    
                    <div class="x_panel">
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

<script>
    $(function () {
        $( "#save_data" ).click(function( event ) {
            var parametros = {
                                'm_ncorr' : $("#m_ncorr").val()
                             };
            $.ajax({
                    type: "POST",
                    url: "action/view_imprime_guia.php",
                    data: parametros,
                    beforeSend: function(objeto){
                        $("#result_user").html("Mensaje: Cargando...");
                        }
            }).done(function (datos){
                
                $("#resultados").html(datos);

            });
          event.preventDefault();
        })
    });
</script>