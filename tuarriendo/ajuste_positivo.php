<?php
    include_once "config/config.php";//Contiene funcion que conecta a la base de datos
    global $con;
    ?>    
    <div class="" role="main"><!-- page content -->
        <input type="hidden" name="arr_fila" id="arr_fila">
        <input type="hidden" name="arr_codigo" id="arr_codigo">
        <input type="hidden" name="arr_cantidad" id="arr_cantidad">
        <input type="hidden" name="arr_descripcion" id="arr_descripcion">
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <h3>Ajuste (+)</h3>
                <div id="resultado_accion"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <input type="text" name="fecha" id="fecha" class="form-control pull-right" >
                        <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <select name="movim_bodega" id="movim_bodega" required type="text" class="form-control" placeholder="Menús">
                            <?php 
                                $query=mysqli_query($con,"select nombre, b_ncorr from bodegas");
                                while ($row=mysqli_fetch_array($query)) {
                                            ?>
                                <option value="<?php echo $row['b_ncorr']?>"><?php echo ($row['nombre'])?></option>
                            <?php }?>
                        </select>    
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <textarea id="obervacion" required type="text" class="form-control" placeholder="Observacion"></textarea>
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Listado</h2>
                            <div class="clearfix"></div>
                            <div class="panel">
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    <input id="codigo" required type="text" class="form-control" placeholder="Codigo"
                                        onblur='buscarDescripcion()'/>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input id="descripcion" required type="text" class="form-control" placeholder="Descripcion" readonly="readonly" />
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    <input id="cantidad" required type="text" class="form-control" placeholder="Cantidad"/>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    <button id="save_line" type="button" class="btn btn-info">+</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
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
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button id="save_data" type="button" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    
                </div>
            </div>
        </div>
    </div><!-- /page content -->

<script type="text/javascript" src="js/ajuste_positivo.js"></script>

<script>
    $(function () {
        $( "#save_data" ).click(function( event ) {
            var parametros = {
                                'fecha' : $("#fecha").val() , 
                                'movim_bodega' : $("#movim_bodega").val() , 
                                'obervacion' : $("#obervacion").val() , 
                                'arr_codigo' : $("#arr_codigo").val() , 
                                'arr_cantidad' : $("#arr_cantidad").val() , 
                                'arr_descripcion' : $("#arr_descripcion").val()
                             };
            $.ajax({
                    type: "POST",
                    url: "action/add_ajuste_positivo.php",
                    data: parametros,
                    beforeSend: function(objeto){
                        $("#result_user").html("Mensaje: Cargando...");
                        }
            }).done(function (datos){
                
                $("#resultado_accion").html(datos);

            });
          event.preventDefault();
        })
    });
</script>